<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class LaravelStudioController extends Controller
{
    /**
     * Display Laravel Architecture & Eloquent Studio.
     */
    public function index()
    {
        $books = Book::all();

        // Read real file contents from disk
        $files = [
            [
                'id' => 'model-book',
                'name' => 'Book.php (Eloquent Model)',
                'path' => 'app/Models/Book.php',
                'language' => 'php',
                'description' => 'Model Eloquent untuk entitas Buku dengan Accessor cover, Relasi Kategori, Boot Hooks, dan Query Scopes.',
                'content' => file_exists(base_path('app/Models/Book.php')) ? file_get_contents(base_path('app/Models/Book.php')) : '',
            ],
            [
                'id' => 'controller-book',
                'name' => 'BookController.php (CRUD & Upload)',
                'path' => 'app/Http/Controllers/BookController.php',
                'language' => 'php',
                'description' => 'Controller menangani listing katalog, pencarian, validasi upload cover ke Storage, dan Eloquent CRUD.',
                'content' => file_exists(base_path('app/Http/Controllers/BookController.php')) ? file_get_contents(base_path('app/Http/Controllers/BookController.php')) : '',
            ],
            [
                'id' => 'migration-books',
                'name' => '2026_10_06_000002_create_books_table.php',
                'path' => 'database/migrations/2026_10_06_000002_create_books_table.php',
                'language' => 'php',
                'description' => 'Migrasi schema database dengan indexed foreign key, composite search index, dan kolom enum status.',
                'content' => file_exists(database_path('migrations/2026_10_06_000002_create_books_table.php')) ? file_get_contents(database_path('migrations/2026_10_06_000002_create_books_table.php')) : '',
            ],
            [
                'id' => 'routes-web',
                'name' => 'web.php (Routing & Resource)',
                'path' => 'routes/web.php',
                'language' => 'php',
                'description' => 'Deklarasi rute RESTful resource untuk CRUD buku, filter, ekspor data, dan manajemen inventaris.',
                'content' => file_exists(base_path('routes/web.php')) ? file_get_contents(base_path('routes/web.php')) : '',
            ],
            [
                'id' => 'view-index',
                'name' => 'index.blade.php (Katalog & Blade UI)',
                'path' => 'resources/views/books/index.blade.php',
                'language' => 'blade',
                'description' => 'Template view Blade engine dengan komponen tabel, modal form dinamis, filter, dan pagination links.',
                'content' => file_exists(resource_path('views/books/index.blade.php')) ? file_get_contents(resource_path('views/books/index.blade.php')) : '',
            ],
        ];

        return view('laravel-studio.index', compact('books', 'files'));
    }

    /**
     * Execute live Eloquent query and return query result with generated SQL.
     */
    public function runQuery(Request $request)
    {
        $type = $request->input('type', 'critical_stock');

        switch ($type) {
            case 'critical_stock':
                $query = Book::criticalStock();
                $sql = $query->toSql();
                $result = $query->get()->map(function ($b) {
                    return [
                        'id' => $b->id,
                        'title' => $b->title,
                        'stock' => $b->stock,
                        'status' => $b->status,
                        'shelf_location' => $b->shelf_location,
                    ];
                });
                break;

            case 'latest_paginate':
                $query = Book::orderBy('updated_at', 'desc')->take(5);
                $sql = $query->toSql();
                $result = $query->get()->map(function ($b) {
                    return [
                        'id' => $b->id,
                        'title' => $b->title,
                        'author' => $b->author,
                        'category' => $b->category,
                        'stock' => $b->stock,
                    ];
                });
                break;

            case 'category_group':
                $query = Book::selectRaw('category, COUNT(*) as total_titles, SUM(stock) as total_stock')->groupBy('category');
                $sql = $query->toSql();
                $result = $query->get();
                break;

            case 'image_storage':
                $query = Book::select('id', 'title', 'cover_image', 'file_size_kb');
                $sql = $query->toSql();
                $result = $query->get()->map(function ($b) {
                    return [
                        'id' => $b->id,
                        'title' => $b->title,
                        'storage_path' => $b->cover_image,
                        'full_url' => $b->cover_url,
                        'file_size_kb' => $b->file_size_kb ?? 50,
                    ];
                });
                break;

            default:
                $query = Book::query();
                $sql = $query->toSql();
                $result = $query->take(5)->get();
                break;
        }

        return response()->json([
            'query_type' => $type,
            'sql' => $sql,
            'result' => $result,
        ]);
    }
}
