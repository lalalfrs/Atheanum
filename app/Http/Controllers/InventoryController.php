<?php

namespace App\Http\Controllers;

use App\Models\Book;

class InventoryController extends Controller
{
    /**
     * Display physical shelf audit and distribution.
     */
    public function index()
    {
        $books = Book::all();

        $shelves = [
            [
                'code' => 'Rak A',
                'name' => 'Rak Koleksi Self Improvement & Psikologi',
                'location' => 'Lantai 1 Sayap Barat',
                'capacity' => 150,
            ],
            [
                'code' => 'Rak B',
                'name' => 'Rak Sastra & Fiksi Indonesia',
                'location' => 'Lantai 1 Sayap Timur',
                'capacity' => 150,
            ],
            [
                'code' => 'Rak C',
                'name' => 'Rak Filsafat, Sejarah & Sosial',
                'location' => 'Lantai 2 Sayap Barat',
                'capacity' => 150,
            ],
            [
                'code' => 'Rak D',
                'name' => 'Rak Referensi & Sistem Informasi',
                'location' => 'Lantai 2 Sayap Timur',
                'capacity' => 150,
            ],
            [
                'code' => 'Rak T',
                'name' => 'Rak Rekayasa Teknologi & Komputer',
                'location' => 'Lantai 2 Ruang Khusus',
                'capacity' => 150,
            ],
        ];

        // Enrich shelf data with matching books
        foreach ($shelves as &$shelf) {
            $shelf['books'] = $books->filter(function ($b) use ($shelf) {
                return stripos($b->shelf_location, $shelf['code']) !== false;
            })->values();

            $shelf['total_stock'] = $shelf['books']->sum('stock');
            $shelf['total_copies'] = $shelf['books']->sum('total_copies');
        }

        return view('inventory.index', compact('shelves', 'books'));
    }
}
