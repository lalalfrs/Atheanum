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
            $query->where('status', $status);
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
            'returned' => $isStaff
                ? Loan::where('status', 'dikembalikan')->count()
                : $currentUser->loans()->where('status', 'dikembalikan')->count(),
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

        // Batasi peminjaman aktif maksimal 3 buku per anggota
        $activeLoansCount = $currentUser->loans()->where('status', 'dipinjam')->count();
        if ($activeLoansCount >= 3) {
            return back()->with('error', 'Batas maksimal peminjaman aktif tercapai (3 buku). Harap kembalikan buku sebelumnya terlebih dahulu.');
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

        // Buat rekaman peminjaman (durasi 7 hari)
        Loan::create([
            'user_id' => $currentUser->id,
            'book_id' => $book->id,
            'borrowed_at' => now()->toDateString(),
            'due_date' => now()->addDays(7)->toDateString(),
            'status' => 'dipinjam',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('loans.index')
            ->with('success', "Peminjaman buku \"{$book->title}\" berhasil dicatat. Batas pengembalian adalah 7 hari dari sekarang.");
    }

    /**
     * Proses pengembalian buku pinjaman.
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

        // Pulihkan stok buku
        $loan->book()->increment('stock');

        // Perbarui status peminjaman
        $loan->update([
            'status' => 'dikembalikan',
            'returned_at' => now()->toDateString(),
        ]);

        return back()->with('success', "Buku \"{$loan->book->title}\" berhasil dikembalikan ke rak katalog perpustakaan.");
    }
}
