<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BookController extends Controller
{
    /**
     * Display a listing of the books with filtering, searching, and pagination.
     */
    public function index(Request $request)
    {
        $query = Book::query();

        // 1. Text Search (title, subtitle, author, isbn, shelf_location)
        if ($search = $request->input('search')) {
            $query->search($search);
        }

        // 2. Category Filter
        if ($category = $request->input('category')) {
            if ($category !== 'Semua Kategori' && $category !== 'all') {
                $query->where('category', $category);
            }
        }

        // 3. Status Filter
        if ($status = $request->input('status')) {
            if ($status === 'Tersedia') {
                $query->where('status', 'Tersedia');
            } elseif ($status === 'Stok Kritis') {
                $query->where('status', 'Stok Kritis');
            } elseif ($status === 'Habis' || $status === 'Habis / Kosong') {
                $query->where('status', 'Habis');
            }
        }

        // 4. Year Filter
        if ($yearFilter = $request->input('year')) {
            if ($yearFilter === '2024') {
                $query->where('year', 2024);
            } elseif ($yearFilter === '2023') {
                $query->where('year', 2023);
            } elseif ($yearFilter === '2020 - 2022' || $yearFilter === '2020-2022') {
                $query->whereBetween('year', [2020, 2022]);
            } elseif ($yearFilter === '2010 - 2019' || $yearFilter === '2010-2019') {
                $query->whereBetween('year', [2010, 2019]);
            } elseif ($yearFilter === '< 2010' || $yearFilter === '<2010') {
                $query->where('year', '<', 2010);
            }
        }

        // 5. Sorting
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'stock_desc':
                $query->orderBy('stock', 'desc');
                break;
            case 'year_desc':
                $query->orderBy('year', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('updated_at', 'desc');
                break;
        }

        // Eloquent Pagination: 7 books per page
        $books = $query->paginate(7)->withQueryString();

        // Statistics using Eloquent
        $stats = [
            'total_titles' => Book::count(),
            'total_physical' => Book::sum('total_copies'),
            'total_stock' => Book::sum('stock'),
            'critical_count' => Book::where('status', 'Stok Kritis')->count(),
            'out_of_stock_count' => Book::where('status', 'Habis')->count(),
            'categories_count' => Category::count(),
        ];

        $categories = Category::orderBy('name')->get();

        if ($request->wantsJson()) {
            return response()->json([
                'books' => $books,
                'stats' => $stats,
            ]);
        }

        return view('books.index', compact('books', 'stats', 'categories'));
    }

    /**
     * Show the form for creating a new book.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('books.create', compact('categories'));
    }

    /**
     * Store a newly created book in storage using Eloquent.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'isbn' => 'required|string|max:50|unique:books,isbn',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'year' => 'required|integer|min:1900|max:'.(date('Y') + 2),
            'stock' => 'required|integer|min:0',
            'total_copies' => 'nullable|integer|min:0',
            'shelf_location' => 'required|string|max:50',
            'cover_image' => 'nullable|string',
            'cover_file' => 'nullable|image|mimes:jpeg,png,webp,jpg|max:5120',
            'description' => 'nullable|string',
        ]);

        // Connect with Category relation if matching
        $category = Category::where('name', $validated['category'])->first();
        if ($category) {
            $validated['category_id'] = $category->id;
        }

        // Handle uploaded cover file
        if ($request->hasFile('cover_file')) {
            $file = $request->file('cover_file');
            $filename = 'cover_'.Str::slug($validated['title']).'_'.time().'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('books', $filename, 'public');
            $validated['cover_image'] = $path;
            $validated['image_storage_path'] = $path;
            $validated['file_size_kb'] = round($file->getSize() / 1024);
        } elseif (! empty($validated['cover_image'])) {
            $validated['image_storage_path'] = 'external/'.Str::slug($validated['title']).'.webp';
            $validated['file_size_kb'] = 50;
        }

        if (empty($validated['total_copies']) || $validated['total_copies'] < $validated['stock']) {
            $validated['total_copies'] = $validated['stock'];
        }

        // Eloquent Create
        $book = Book::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Buku “{$book->title}” berhasil disimpan ke dalam basis data katalog.",
                'book' => $book,
            ]);
        }

        return redirect()->route('books.index')
            ->with('success', "Buku “{$book->title}” berhasil disimpan ke dalam basis data katalog.");
    }

    /**
     * Display the specified book.
     */
    public function show(Book $book, Request $request)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'book' => $book->load('categoryRelation'),
                'cover_url' => $book->cover_url,
            ]);
        }

        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified book.
     */
    public function edit(Book $book)
    {
        $categories = Category::orderBy('name')->get();

        return view('books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified book in storage using Eloquent.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'isbn' => 'required|string|max:50|unique:books,isbn,'.$book->id,
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'year' => 'required|integer|min:1900|max:'.(date('Y') + 2),
            'stock' => 'required|integer|min:0',
            'total_copies' => 'nullable|integer|min:0',
            'shelf_location' => 'required|string|max:50',
            'cover_image' => 'nullable|string',
            'cover_file' => 'nullable|image|mimes:jpeg,png,webp,jpg|max:5120',
            'description' => 'nullable|string',
        ]);

        $category = Category::where('name', $validated['category'])->first();
        if ($category) {
            $validated['category_id'] = $category->id;
        }

        // Handle uploaded cover file
        if ($request->hasFile('cover_file')) {
            // Delete old file if present in local public storage
            if ($book->cover_image && ! str_starts_with($book->cover_image, 'http')) {
                Storage::disk('public')->delete($book->cover_image);
            }

            $file = $request->file('cover_file');
            $filename = 'cover_'.Str::slug($validated['title']).'_'.time().'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('books', $filename, 'public');
            $validated['cover_image'] = $path;
            $validated['image_storage_path'] = $path;
            $validated['file_size_kb'] = round($file->getSize() / 1024);
        }

        if (empty($validated['total_copies']) || $validated['total_copies'] < $validated['stock']) {
            $validated['total_copies'] = max($book->total_copies, $validated['stock']);
        }

        // Eloquent Update
        $book->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Buku “{$book->title}” berhasil diperbarui dalam basis data katalog.",
                'book' => $book,
            ]);
        }

        return redirect()->route('books.index')
            ->with('success', "Buku “{$book->title}” berhasil diperbarui dalam basis data katalog.");
    }

    /**
     * Remove the specified book from storage using Eloquent.
     */
    public function destroy(Book $book, Request $request)
    {
        $title = $book->title;
        // Eloquent Delete (will trigger booted deleting hook in Book model to remove storage image)
        $book->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Buku “{$title}” telah berhasil dihapus dari sistem katalog.",
            ]);
        }

        return redirect()->route('books.index')
            ->with('success', "Buku “{$title}” telah berhasil dihapus dari sistem katalog.");
    }

    /**
     * Quick stock increment or decrement via Eloquent.
     */
    public function updateStock(Request $request, Book $book)
    {
        $delta = (int) $request->input('delta', 1);
        $newStock = max(0, $book->stock + $delta);

        $book->stock = $newStock;
        if ($book->total_copies < $newStock) {
            $book->total_copies = $newStock;
        }
        $book->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'stock' => $book->stock,
                'status' => $book->status,
                'message' => "Stok “{$book->title}” berhasil diubah menjadi {$book->stock}.",
            ]);
        }

        return redirect()->back()
            ->with('success', "Stok “{$book->title}” berhasil disesuaikan ({$book->stock} eksemplar).");
    }

    /**
     * Export all books to CSV.
     */
    public function exportCsv(): StreamedResponse
    {
        $fileName = 'athenaeum_katalog_buku_'.date('Y-m-d').'.csv';
        $books = Book::orderBy('title')->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($books) {
            $handle = fopen('php://output', 'w');
            // Write UTF-8 BOM
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, [
                'ID',
                'Judul Buku',
                'Subjudul',
                'ISBN',
                'Penulis',
                'Penerbit',
                'Kategori',
                'Tahun Terbit',
                'Stok Tersedia',
                'Total Eksemplar',
                'Lokasi Rak',
                'Status',
                'Cover URL / Path',
                'Terakhir Diperbarui',
            ]);

            foreach ($books as $b) {
                fputcsv($handle, [
                    $b->id,
                    $b->title,
                    $b->subtitle,
                    $b->isbn,
                    $b->author,
                    $b->publisher,
                    $b->category,
                    $b->year,
                    $b->stock,
                    $b->total_copies,
                    $b->shelf_location,
                    $b->status,
                    $b->cover_image,
                    $b->updated_at?->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Export database dump in SQL format.
     */
    public function exportSql(): StreamedResponse
    {
        $fileName = 'athenaeum_library_mysql_'.date('Y-m-d').'.sql';
        $books = Book::all();

        $headers = [
            'Content-Type' => 'application/sql; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        return response()->stream(function () use ($books) {
            $out = fopen('php://output', 'w');
            fwrite($out, "-- Athenaeum Library System Database Dump\n");
            fwrite($out, '-- Generated at: '.date('Y-m-d H:i:s')."\n");
            fwrite($out, "-- Laravel Eloquent ORM Database Export\n\n");
            fwrite($out, "SET FOREIGN_KEY_CHECKS=0;\nDROP TABLE IF EXISTS `books`;\n\n");
            fwrite($out, "CREATE TABLE `books` (\n");
            fwrite($out, "  `id` bigint unsigned NOT NULL AUTO_INCREMENT,\n");
            fwrite($out, "  `title` varchar(255) NOT NULL,\n");
            fwrite($out, "  `subtitle` varchar(255) DEFAULT NULL,\n");
            fwrite($out, "  `isbn` varchar(50) NOT NULL UNIQUE,\n");
            fwrite($out, "  `author` varchar(255) NOT NULL,\n");
            fwrite($out, "  `publisher` varchar(255) NOT NULL,\n");
            fwrite($out, "  `category` varchar(100) NOT NULL,\n");
            fwrite($out, "  `year` smallint unsigned NOT NULL,\n");
            fwrite($out, "  `stock` int unsigned NOT NULL DEFAULT '0',\n");
            fwrite($out, "  `total_copies` int unsigned NOT NULL DEFAULT '1',\n");
            fwrite($out, "  `shelf_location` varchar(50) NOT NULL,\n");
            fwrite($out, "  `status` enum('Tersedia','Stok Kritis','Habis') NOT NULL DEFAULT 'Tersedia',\n");
            fwrite($out, "  `cover_image` text,\n");
            fwrite($out, "  `description` text,\n");
            fwrite($out, "  `created_at` timestamp NULL DEFAULT NULL,\n");
            fwrite($out, "  `updated_at` timestamp NULL DEFAULT NULL,\n");
            fwrite($out, "  PRIMARY KEY (`id`)\n");
            fwrite($out, ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n");

            if ($books->isNotEmpty()) {
                fwrite($out, "INSERT INTO `books` (`id`, `title`, `isbn`, `author`, `publisher`, `category`, `year`, `stock`, `total_copies`, `shelf_location`, `status`, `cover_image`, `created_at`, `updated_at`) VALUES\n");
                $rows = [];
                foreach ($books as $b) {
                    $title = addslashes($b->title);
                    $author = addslashes($b->author);
                    $publisher = addslashes($b->publisher);
                    $cover = addslashes($b->cover_image ?? '');
                    $createdAt = $b->created_at?->format('Y-m-d H:i:s') ?? date('Y-m-d H:i:s');
                    $updatedAt = $b->updated_at?->format('Y-m-d H:i:s') ?? date('Y-m-d H:i:s');
                    $rows[] = "({$b->id}, '{$title}', '{$b->isbn}', '{$author}', '{$publisher}', '{$b->category}', {$b->year}, {$b->stock}, {$b->total_copies}, '{$b->shelf_location}', '{$b->status}', '{$cover}', '{$createdAt}', '{$updatedAt}')";
                }
                fwrite($out, implode(",\n", $rows).";\n");
            }
            fclose($out);
        }, 200, $headers);
    }
}
