<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EbookController extends Controller
{
    /**
     * Tampilkan galeri e-book & koleksi digital perpustakaan.
     */
    public function index(Request $request): View
    {
        $query = Book::where('is_ebook', true);

        if ($search = $request->input('search')) {
            $query->search($search);
        }

        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        $ebooks = $query->latest()->paginate(12)->withQueryString();
        $categories = Book::where('is_ebook', true)->distinct()->pluck('category');

        return view('ebooks.index', compact('ebooks', 'categories'));
    }

    /**
     * Buka antarmuka pembaca e-book digital interaktif.
     */
    public function read(Book $book): View
    {
        // Konten e-book bawaan jika belum terisi di database
        if (empty($book->ebook_content)) {
            $book->ebook_content = "### Bab 1: Pengantar dan Latar Belakang\n\nSelamat membaca koleksi digital {$book->title} karya {$book->author}.\n\nBuku ini tersimpan dalam repositori digital Athenaeum Library System. Melalui platform ini, mahasiswa dan anggota perpustakaan dapat mengakses teks pustaka secara mandiri dengan antarmuka yang dioptimalkan untuk kenyamanan membaca.\n\n### Bab 2: Diskusi Teoretis & Kerangka Analisis\n\nPembahasan bab ini mengupas konsep-konsep kunci yang melandasi kajian utama. Setiap subbab dirancang untuk memberikan pemahaman komprehensif mengenai metodologi serta implikasi praktis yang terkandung di dalam naskah klasik ini.\n\n### Bab 3: Catatan Akhir dan Kesimpulan\n\nPreservasi digital memastikan setiap karya ilmiah dan sastra tetap lestari serta dapat diakses oleh generasi mendatang.";
        }

        return view('ebooks.read', compact('book'));
    }
}
