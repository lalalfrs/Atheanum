<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoanController extends Controller
{
    /**
     * Tampilkan daftar peminjaman buku.
     */
    public function index(Request $request): View
    {
        /** @var User $currentUser */
        $currentUser = $request->user();

        $isStaff = $currentUser->isLibrarian();

        $query = Loan::with(['book', 'user']);

        // Jika anggota biasa, hanya tampilkan riwayat peminjaman miliknya sendiri
        if (! $isStaff) {
            $query->where('user_id', $currentUser->id);
        }

        if ($status = $request->input('status')) {
            if ($status === 'terlambat') {
                $query->where('status', 'dipinjam')
                    ->where('due_date', '<', now()->toDateString());
            } elseif ($status === 'denda') {
                $query->where('fine_amount', '>', 0)
                    ->where('fine_paid', false);
            } else {
                $query->where('status', $status);
            }
        }

        if ($search = $request->input('search')) {
            $query->whereHas('book', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        $loans = $query->latest('borrowed_at')->paginate(12)->withQueryString();

        $stats = [
            'active' => $isStaff
                ? Loan::where('status', 'dipinjam')->count()
                : $currentUser->loans()->where('status', 'dipinjam')->count(),
            'overdue' => $isStaff
                ? Loan::where('status', 'dipinjam')->where('due_date', '<', now()->toDateString())->count()
                : $currentUser->loans()->where('status', 'dipinjam')->where('due_date', '<', now()->toDateString())->count(),
            'returned' => $isStaff
                ? Loan::where('status', 'dikembalikan')->count()
                : $currentUser->loans()->where('status', 'dikembalikan')->count(),
            'unpaid_fines' => $isStaff
                ? Loan::where('fine_paid', false)->where('fine_amount', '>', 0)->sum('fine_amount')
                : $currentUser->loans()->where('fine_paid', false)->where('fine_amount', '>', 0)->sum('fine_amount'),
            'total' => $isStaff
                ? Loan::count()
                : $currentUser->loans()->count(),
        ];

        return view('loans.index', compact('loans', 'stats', 'isStaff'));
    }

    /**
     * Ajukan peminjaman buku fisik.
     */
    public function store(Request $request): RedirectResponse
    {
        /** @var User $currentUser */
        $currentUser = $request->user();

        $validated = $request->validate([
            'book_id' => ['required', 'exists:books,id'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $book = Book::findOrFail($validated['book_id']);

        // Cek ketersediaan stok buku
        if ($book->stock <= 0) {
            return back()->with('error', "Maaf, eksemplar fisik buku \"{$book->title}\" saat ini sedang habis.");
        }

        // Cek apakah anggota memiliki tunggakan denda sirkulasi yang belum lunas
        $unpaidFines = $currentUser->loans()
            ->where('fine_paid', false)
            ->where('fine_amount', '>', 0)
            ->sum('fine_amount');

        if ($unpaidFines > 0) {
            return back()->with('error', 'Peminjaman ditolak: Anda memiliki tunggakan denda keterlambatan sebesar Rp '.number_format($unpaidFines, 0, ',', '.').'. Harap selesaikan denda terlebih dahulu di meja pustakawan.');
        }

        $activeLoansCount = $currentUser->loans()->active()->count();
        if ($activeLoansCount >= Loan::MAX_ACTIVE_LOANS) {
            return back()->with('error', 'Batas kuota maksimal peminjaman aktif tercapai ('.Loan::MAX_ACTIVE_LOANS.' buku). Harap kembalikan buku sebelumnya terlebih dahulu.');
        }

        // Cek apakah anggota sedang meminjam buku yang sama
        $alreadyBorrowed = $currentUser->loans()
            ->where('book_id', $book->id)
            ->where('status', 'dipinjam')
            ->exists();

        if ($alreadyBorrowed) {
            return back()->with('error', "Anda saat ini sudah meminjam eksemplar buku \"{$book->title}\".");
        }

        // Kurangi stok fisik buku
        $book->decrement('stock');

        Loan::create([
            'user_id' => $currentUser->id,
            'book_id' => $book->id,
            'borrowed_at' => now()->toDateString(),
            'due_date' => now()->addDays(Loan::LOAN_DURATION_DAYS)->toDateString(),
            'status' => 'dipinjam',
            'fine_amount' => 0,
            'fine_paid' => true,
            'renewed_count' => 0,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('loans.index')
            ->with('success', "Peminjaman buku \"{$book->title}\" berhasil dicatat. Batas pengembalian adalah ".Loan::LOAN_DURATION_DAYS.' hari dari sekarang.');
    }

    /**
     * Proses pengembalian buku pinjaman & kalkulasi denda otomatis.
     */
    public function returnBook(Request $request, Loan $loan): RedirectResponse
    {
        /** @var User $currentUser */
        $currentUser = $request->user();

        // Verifikasi kepemilikan peminjaman atau izin staf perpustakaan
        if (! $currentUser->isLibrarian() && $loan->user_id !== $currentUser->id) {
            abort(403, 'Anda tidak berwenang mengembalikan catatan peminjaman anggota lain.');
        }

        if ($loan->status === 'dikembalikan') {
            return back()->with('error', 'Buku ini sudah berstatus dikembalikan sebelumnya.');
        }

        // Pulihkan stok buku jika relasi buku masih ada
        $loan->book()?->increment('stock');

        $bookTitle = $loan->book?->title ?? 'Buku';

        // Hitung denda jika melewati tanggal jatuh tempo
        $fineAmount = 0;
        $returnDate = now()->toDateString();
        $message = "Buku \"{$bookTitle}\" berhasil dikembalikan ke rak katalog perpustakaan.";

        if ($loan->due_date && now()->startOfDay()->isAfter($loan->due_date->startOfDay())) {
            $overdueDays = (int) $loan->due_date->startOfDay()->diffInDays(now()->startOfDay(), false);
            if ($overdueDays > 0) {
                $fineAmount = $overdueDays * Loan::DAILY_FINE_RATE;
                $message = "Buku \"{$bookTitle}\" dikembalikan terlambat {$overdueDays} hari. Denda keterlambatan tercatat sebesar Rp ".number_format($fineAmount, 0, ',', '.').'.';
            }
        }

        // Perbarui status peminjaman
        $loan->update([
            'status' => 'dikembalikan',
            'returned_at' => $returnDate,
            'fine_amount' => $fineAmount,
            'fine_paid' => $fineAmount === 0,
            'fine_paid_at' => $fineAmount === 0 ? now()->toDateString() : null,
        ]);

        return back()->with('success', $message);
    }

    /**
     * Perpanjang masa peminjaman buku (+7 hari).
     */
    public function renew(Request $request, Loan $loan): RedirectResponse
    {
        /** @var User $currentUser */
        $currentUser = $request->user();

        if (! $currentUser->isLibrarian() && $loan->user_id !== $currentUser->id) {
            abort(403, 'Anda tidak berwenang memperpanjang catatan peminjaman ini.');
        }

        if ($loan->status !== 'dipinjam') {
            return back()->with('error', 'Hanya buku yang sedang aktif dipinjam yang dapat diperpanjang.');
        }

        if ($loan->isOverdue()) {
            return back()->with('error', 'Buku tidak dapat diperpanjang karena sudah melewati tanggal jatuh tempo (terlambat). Harap segera kembalikan ke perpustakaan.');
        }

        if ($loan->renewed_count >= Loan::MAX_RENEWALS) {
            return back()->with('error', 'Batas maksimal perpanjangan masa pinjam telah tercapai (maksimal '.Loan::MAX_RENEWALS.' kali perpanjangan).');
        }

        $newDueDate = $loan->due_date->copy()->addDays(Loan::RENEWAL_DAYS);
        $bookTitle = $loan->book?->title ?? 'Buku';

        $loan->update([
            'due_date' => $newDueDate->toDateString(),
            'renewed_count' => $loan->renewed_count + 1,
        ]);

        return back()->with('success', "Masa peminjaman buku \"{$bookTitle}\" berhasil diperpanjang ".Loan::RENEWAL_DAYS." hari hingga {$newDueDate->format('d M Y')}.");
    }

    /**
     * Pelunasan denda keterlambatan oleh pustakawan.
     */
    public function payFine(Request $request, Loan $loan): RedirectResponse
    {
        /** @var User $currentUser */
        $currentUser = $request->user();

        if (! $currentUser->isLibrarian()) {
            abort(403, 'Hanya pustakawan yang dapat mencatat pelunasan denda.');
        }

        if ($loan->fine_amount <= 0 || $loan->fine_paid) {
            return back()->with('error', 'Peminjaman ini tidak memiliki tagihan denda yang belum dibayar.');
        }

        $bookTitle = $loan->book?->title ?? 'Buku';

        $loan->update([
            'fine_paid' => true,
            'fine_paid_at' => now()->toDateString(),
        ]);

        return back()->with('success', 'Pembayaran denda sebesar Rp '.number_format($loan->fine_amount, 0, ',', '.')." untuk buku \"{$bookTitle}\" berhasil dicatat lunas.");
    }
}
