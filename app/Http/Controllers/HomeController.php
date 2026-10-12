<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\LibraryEvent;
use App\Models\News;
use App\Models\SiteVisit;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Beranda publik: halaman pertama setelah membuka situs atau login.
     */
    public function index(Request $request): View
    {
        SiteVisit::record($request);

        return view('home', [
            'services' => $this->services(),
            'latestNews' => News::published()->take(3)->get(),
            'upcomingEvents' => LibraryEvent::upcoming()->take(3)->get(),
            'visits' => SiteVisit::summary(),
            'collection' => [
                'titles' => Book::count(),
                'ebooks' => Book::where('is_ebook', true)->count(),
            ],
            'mapQuery' => config('library.map_query'),
        ]);
    }

    /**
     * Layanan koleksi pada beranda. URL null berarti tautan belum diatur.
     *
     * @return list<array{key: string, label: string, description: string, icon: string, url: ?string, external: bool}>
     */
    private function services(): array
    {
        return [
            [
                'key' => 'repository',
                'label' => 'Repository',
                'description' => 'Skripsi, tesis, dan karya ilmiah sivitas.',
                'icon' => 'inventory',
                'url' => config('library.links.repository'),
                'external' => true,
            ],
            [
                'key' => 'ejournal',
                'label' => 'E-Journal',
                'description' => 'Portal jurnal elektronik institusi.',
                'icon' => 'article',
                'url' => config('library.links.ejournal'),
                'external' => true,
            ],
            [
                'key' => 'cjs',
                'label' => 'CJS per Prodi',
                'description' => 'Pilih program studi untuk membuka CJS-nya.',
                'icon' => 'school',
                'url' => route('cjs.index'),
                'external' => false,
            ],
            [
                'key' => 'ebook',
                'label' => 'E-Book',
                'description' => 'Baca koleksi digital langsung di browser.',
                'icon' => 'auto_stories',
                'url' => route('ebooks.index'),
                'external' => false,
            ],
        ];
    }
}
