<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;

class DashboardController extends Controller
{
    /**
     * Display the Athenaeum Library Dashboard.
     *
     * Semua data diambil dari SQLite via Eloquent ORM —
     * tidak ada raw SQL query di sini, semuanya lewat Model.
     *
     * File database SQLite ada di: database/database.sqlite
     * Buka dengan: DB Browser for SQLite → Open Database → pilih file itu.
     */
    public function index()
    {
        // ┌─────────────────────────────────────────────────────────────┐
        // │  ELOQUENT: Book::orderBy()->get()                           │
        // │  SQL yang dijalankan di belakang layar:                     │
        // │  SELECT * FROM books ORDER BY updated_at DESC               │
        // │  (file: database/database.sqlite → tabel: books)            │
        // └─────────────────────────────────────────────────────────────┘
        $books = Book::orderBy('updated_at', 'desc')->get();

        // ┌─────────────────────────────────────────────────────────────┐
        // │  ELOQUENT COLLECTION METHODS                                │
        // │  $books sudah di-load ke memori (Collection PHP),           │
        // │  jadi ->count(), ->sum(), ->where() di bawah ini            │
        // │  TIDAK menyentuh database lagi — murni PHP di server.       │
        // └─────────────────────────────────────────────────────────────┘
        $stats = [
            // Jumlah total baris di tabel books
            'total_books' => $books->count(),

            // SUM(total_copies) dari Collection (bukan SQL SUM)
            'total_physical_stock' => $books->sum('total_copies'),

            // SUM(stock) — stok yang masih ada di rak
            'total_available_stock' => $books->sum('stock'),

            // Filter koleksi di memori berdasarkan kolom status
            'critical_books_count' => $books->where('status', 'Stok Kritis')->count(),
            'out_of_stock_count' => $books->where('status', 'Habis')->count(),

            // ┌─────────────────────────────────────────────────────────┐
            // │  ELOQUENT: Category::count()                            │
            // │  SQL: SELECT COUNT(*) FROM categories                   │
            // └─────────────────────────────────────────────────────────┘
            'total_categories' => Category::count(),
        ];

        // 4 buku terbaru untuk ditampilkan di kartu dashboard
        // ->take() hanya mengambil N item dari Collection, bukan SQL LIMIT
        $recentBooks = $books->take(4);

        // ┌─────────────────────────────────────────────────────────────┐
        // │  ELOQUENT: Category::withCount('books')->get()              │
        // │  SQL: SELECT categories.*,                                  │
        // │         COUNT(books.id) AS books_count                      │
        // │       FROM categories                                       │
        // │       LEFT JOIN books ON books.category_id = categories.id  │
        // │       GROUP BY categories.id                                │
        // │  Relationship didefinisikan di: app/Models/Category.php     │
        // └─────────────────────────────────────────────────────────────┘
        $categories = Category::withCount('books')->get();

        return view('dashboard', compact('books', 'stats', 'recentBooks', 'categories'));
    }
}
