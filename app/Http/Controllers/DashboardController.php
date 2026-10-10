<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan Dashboard Sistem Perpustakaan Athenaeum yang adaptif berdasarkan peran pengguna.
     */
    public function index(Request $request): View
    {
        /** @var User|null $user */
        $user = $request->user();

        $books = Book::orderBy('updated_at', 'desc')->get();

        $stats = [
            'total_books' => $books->count(),
            'total_physical_stock' => $books->sum('total_copies'),
            'total_available_stock' => $books->sum('stock'),
            'critical_books_count' => $books->where('status', 'Stok Kritis')->count(),
            'out_of_stock_count' => $books->where('status', 'Habis')->count(),
            'total_categories' => Category::count(),
            'total_ebooks' => Book::where('is_ebook', true)->count(),
        ];

        $recentBooks = $books->take(4);
        $categories = Category::withCount('books')->get();

        // Data spesifik pengguna anggota (peminjaman aktif mereka)
        $memberLoans = $user ? $user->loans()->with('book')->where('status', 'dipinjam')->get() : collect();

        // Koleksi e-book rekomendasi untuk dibaca
        $featuredEbooks = Book::where('is_ebook', true)->take(4)->get();

        // Data statistik pengguna untuk Super Admin
        $userStats = [
            'total_users' => User::count(),
            'members' => User::where('role', 'member')->count(),
            'librarians' => User::where('role', 'librarian')->count(),
            'total_active_loans' => Loan::where('status', 'dipinjam')->count(),
        ];

        return view('dashboard', compact(
            'books',
            'stats',
            'recentBooks',
            'categories',
            'memberLoans',
            'featuredEbooks',
            'userStats'
        ));
    }
}
