{{--
    dashboard.blade.php
    ───────────────────────────────────────────────────────────────────────
    Data di halaman ini 100% dari Eloquent ORM → SQLite.
    Lihat: app/Http/Controllers/DashboardController.php untuk detail query.
    Database file: database/database.sqlite
--}}
@extends('layouts.app')

@section('title', 'Dashboard — Athenaeum Library')
@section('page_category', 'Dashboard')

@section('content')
<div class="flex flex-col w-full gap-8">

    {{-- ─────────────────────────────────────────────────────────────────
         HEADER: Judul halaman + tanggal hari ini
         now()->translatedFormat() menggunakan locale dari config/app.php
    ───────────────────────────────────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-2">
        <div>
            <h1 class="font-headline text-2xl font-bold text-[#121c2a] tracking-tight">
                Dashboard Perpustakaan
            </h1>
            <p class="text-sm text-[#6f7a6e] mt-0.5">
                Ringkasan koleksi dan stok fisik · basis data <span class="font-semibold text-emerald-700">SQLite via Eloquent</span>
            </p>
        </div>
        <div class="flex items-center gap-1.5 text-xs text-[#6f7a6e] font-medium bg-white border border-[#e6eeff] rounded-lg px-3 py-1.5 self-start sm:self-auto">
            <span class="material-symbols-outlined text-[16px]">calendar_today</span>
            <span>{{ now()->translatedFormat('l, d F Y') }}</span>
        </div>
    </div>

    {{-- ─────────────────────────────────────────────────────────────────
         TOOLBAR: Aksi utama
    ───────────────────────────────────────────────────────────────────── --}}
    <div class="flex flex-wrap items-center gap-2">
        {{-- Tombol utama: tambah buku --}}
        <a href="{{ route('books.create') }}"
           class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#15803d] hover:bg-[#00652c] text-white font-semibold text-sm rounded-lg shadow-sm transition-colors duration-150 active:scale-95">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Tambah Buku
        </a>

        {{-- Export CSV — trigger Eloquent query di BookController@exportCsv --}}
        <a href="{{ route('books.export.csv') }}"
           class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-gray-50 text-[#121c2a] text-xs font-semibold rounded-lg border border-[#e6eeff] transition-colors">
            <span class="material-symbols-outlined text-[17px] text-[#6f7a6e]">file_download</span>
            Export CSV
        </a>

        {{-- Export SQL Dump dari SQLite --}}
        <a href="{{ route('books.export.sql') }}"
           class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-gray-50 text-[#121c2a] text-xs font-semibold rounded-lg border border-[#e6eeff] transition-colors">
            <span class="material-symbols-outlined text-[17px] text-[#6f7a6e]">database</span>
            Export SQL
        </a>

        {{-- Barcode scanner (UI demo, tidak ada backend) --}}
        <button type="button" onclick="showScanAlert()"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-gray-50 text-[#121c2a] text-xs font-semibold rounded-lg border border-[#e6eeff] transition-colors">
            <span class="material-symbols-outlined text-[17px] text-[#6f7a6e]">qr_code_scanner</span>
            Pindai ISBN
        </button>
    </div>

    {{-- Notifikasi barcode (tersembunyi, muncul saat tombol di atas diklik) --}}
    <div id="scanBarcodeAlert"
         class="hidden -mt-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center justify-between text-xs">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]">qr_code</span>
            <span>Pemindai barcode aktif — siap membaca kode ISBN kartu sirkulasi.</span>
        </div>
        <button onclick="document.getElementById('scanBarcodeAlert').classList.add('hidden')"
                class="text-emerald-700 hover:text-emerald-900 ml-4">✕</button>
    </div>

    {{-- ─────────────────────────────────────────────────────────────────
         KARTU STATISTIK (4 kolom)
         Semua nilai dari $stats — dihitung di DashboardController::index()
         menggunakan Eloquent Collection (bukan SQL terpisah).

         Eloquent yang terlibat:
           Book::orderBy('updated_at','desc')->get()   → semua buku
           $books->count()                             → total_books
           $books->sum('total_copies')                 → total_physical_stock
           $books->sum('stock')                        → total_available_stock
           $books->where('status','Stok Kritis')->count() → critical_books_count
           $books->where('status','Habis')->count()    → out_of_stock_count
           Category::count()                           → total_categories
    ───────────────────────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

        {{-- Kartu 1: Total Judul Buku
             Sumber: $stats['total_books'] = Book::count() lewat Collection --}}
        <div class="bg-white rounded-xl border border-[#e6eeff] p-5 flex flex-col gap-3 hover:border-emerald-300 transition-colors">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-700">
                    <span class="material-symbols-outlined text-[22px]">collections_bookmark</span>
                </div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">Aktif</span>
            </div>
            <div>
                <p class="text-xs font-semibold text-[#6f7a6e] uppercase tracking-wider mb-1">Total Judul</p>
                <p class="font-headline text-3xl font-extrabold text-[#121c2a] leading-none">
                    {{ $stats['total_books'] }}
                    <span class="text-sm font-normal text-[#6f7a6e]">judul</span>
                </p>
                <p class="text-[11px] text-[#6f7a6e] mt-1.5">Katalog buku terdaftar di sistem</p>
            </div>
        </div>

        {{-- Kartu 2: Total Eksemplar Fisik
             Sumber: $stats['total_physical_stock'] = $books->sum('total_copies') --}}
        <div class="bg-white rounded-xl border border-[#e6eeff] p-5 flex flex-col gap-3 hover:border-blue-300 transition-colors">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                    <span class="material-symbols-outlined text-[22px]">menu_book</span>
                </div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">Fisik</span>
            </div>
            <div>
                <p class="text-xs font-semibold text-[#6f7a6e] uppercase tracking-wider mb-1">Eksemplar Fisik</p>
                <p class="font-headline text-3xl font-extrabold text-[#121c2a] leading-none">
                    {{ $stats['total_physical_stock'] }}
                    <span class="text-sm font-normal text-[#6f7a6e]">eksemplar</span>
                </p>
                <p class="text-[11px] text-[#6f7a6e] mt-1.5">
                    Tersedia di rak:
                    <strong class="text-emerald-700">{{ $stats['total_available_stock'] }}</strong> buku
                </p>
            </div>
        </div>

        {{-- Kartu 3: Stok Kritis
             Sumber: $stats['critical_books_count'] = $books->where('status','Stok Kritis')->count()
             Status ditulis otomatis oleh Book::booted() saat save (lihat app/Models/Book.php) --}}
        <div class="bg-white rounded-xl border border-[#e6eeff] p-5 flex flex-col gap-3 hover:border-amber-300 transition-colors">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600">
                    <span class="material-symbols-outlined text-[22px]">warning</span>
                </div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full">≤ 3 eks</span>
            </div>
            <div>
                <p class="text-xs font-semibold text-[#6f7a6e] uppercase tracking-wider mb-1">Stok Kritis</p>
                <p class="font-headline text-3xl font-extrabold text-amber-600 leading-none">
                    {{ $stats['critical_books_count'] }}
                    <span class="text-sm font-normal text-[#6f7a6e]">judul</span>
                </p>
                <p class="text-[11px] text-[#6f7a6e] mt-1.5">
                    {{ $stats['out_of_stock_count'] }} judul sudah habis stok
                </p>
            </div>
        </div>

        {{-- Kartu 4: Kategori DDC
             Sumber: $stats['total_categories'] = Category::count()
             Query SQL: SELECT COUNT(*) FROM categories --}}
        <div class="bg-white rounded-xl border border-[#e6eeff] p-5 flex flex-col gap-3 hover:border-emerald-300 transition-colors">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-700">
                    <span class="material-symbols-outlined text-[22px]">category</span>
                </div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">DDC</span>
            </div>
            <div>
                <p class="text-xs font-semibold text-[#6f7a6e] uppercase tracking-wider mb-1">Kategori</p>
                <p class="font-headline text-3xl font-extrabold text-[#121c2a] leading-none">
                    {{ $stats['total_categories'] }}
                    <span class="text-sm font-normal text-[#6f7a6e]">sektor</span>
                </p>
                <p class="text-[11px] text-[#6f7a6e] mt-1.5">Klasifikasi Dewey Decimal</p>
            </div>
        </div>
    </div>

    {{-- ─────────────────────────────────────────────────────────────────
         BUKU TERBARU
         Sumber: $recentBooks = $books->take(4)
         Data dari query awal Book::orderBy('updated_at','desc')->get()
         cover_url adalah Eloquent Accessor — lihat Book::coverUrl() di
         app/Models/Book.php, method coverUrl(): Attribute
    ───────────────────────────────────────────────────────────────────── --}}
    <div>
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="font-headline text-lg font-bold text-[#121c2a]">Buku Terbaru</h2>
                <p class="text-xs text-[#6f7a6e]">4 buku yang terakhir diperbarui di katalog</p>
            </div>
            <a href="{{ route('books.index') }}"
               class="text-xs font-bold text-emerald-700 hover:text-emerald-900 flex items-center gap-1">
                Lihat Semua
                <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($recentBooks as $book)
            {{-- $book adalah instance dari Eloquent Model Book
                 $book->cover_url dipanggil lewat Accessor (bukan kolom DB) --}}
            <div class="bg-white rounded-xl border border-[#e6eeff] p-4 flex flex-col justify-between hover:shadow-sm transition-shadow">
                <div>
                    {{-- Cover image — dari Accessor Book::coverUrl()
                         jika cover_image kosong → fallback ke Unsplash --}}
                    <div class="relative overflow-hidden rounded-lg aspect-[3/4] mb-3 bg-gray-100">
                        <img src="{{ $book->cover_url }}"
                             alt="{{ $book->title }}"
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        <div class="absolute top-2 right-2">
                            @if($book->status === 'Tersedia')
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-600 text-white">Tersedia</span>
                            @elseif($book->status === 'Stok Kritis')
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500 text-white">Kritis</span>
                            @else
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-600 text-white">Habis</span>
                            @endif
                        </div>
                    </div>

                    {{-- $book->category → kolom 'category' (string) di tabel books --}}
                    <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider block mb-0.5">
                        {{ $book->category }}
                    </span>

                    {{-- $book->title, $book->author, $book->year → kolom langsung dari tabel --}}
                    <h3 class="font-headline font-bold text-sm text-gray-900 line-clamp-1" title="{{ $book->title }}">
                        {{ $book->title }}
                    </h3>
                    <p class="text-xs text-gray-500 line-clamp-1 mb-2">
                        {{ $book->author }} · {{ $book->year }}
                    </p>

                    {{-- Stok dari kolom 'stock' dan 'shelf_location' --}}
                    <div class="flex items-center justify-between text-xs text-gray-600 bg-gray-50 px-2.5 py-1.5 rounded-lg border border-gray-100">
                        <span class="flex items-center gap-1 text-[11px]">
                            <span class="material-symbols-outlined text-[13px] text-gray-400">shelves</span>
                            {{ $book->shelf_location }}
                        </span>
                        <span class="font-bold text-emerald-700 text-[11px]">Stok: {{ $book->stock }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-1.5 pt-3 mt-3 border-t border-gray-100">
                    {{-- $book->id dari primary key Eloquent Model --}}
                    <button type="button"
                            onclick="openBookDetailModal({{ $book->id }})"
                            class="flex-1 py-1.5 bg-[#eff4ff] hover:bg-emerald-700 hover:text-white text-emerald-800 text-xs font-semibold rounded-lg transition-colors flex items-center justify-center gap-1">
                        <span class="material-symbols-outlined text-[15px]">visibility</span>
                        Detail
                    </button>
                    {{-- route('books.edit', $book) — Eloquent model sebagai route model binding --}}
                    <a href="{{ route('books.edit', $book) }}"
                       class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors"
                       title="Edit">
                        <span class="material-symbols-outlined text-[17px]">edit</span>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ─────────────────────────────────────────────────────────────────
         DISTRIBUSI KATEGORI DDC
         Sumber: $categories = Category::withCount('books')->get()
         SQL: SELECT categories.*, COUNT(books.id) AS books_count
              FROM categories LEFT JOIN books ON books.category_id = categories.id
              GROUP BY categories.id
         $cat->books_count → dari withCount(), bukan kolom asli tabel
    ───────────────────────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-xl border border-[#e6eeff] p-5">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-headline font-bold text-base text-gray-900">Distribusi Kategori DDC</h3>
                <p class="text-xs text-gray-500">Klasifikasi koleksi menurut standar Dewey Decimal Classification</p>
            </div>
            <a href="{{ route('categories.index') }}"
               class="text-xs font-bold text-emerald-700 hover:underline">
                Kelola →
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
            @foreach($categories as $cat)
            {{-- $cat->name, $cat->ddc_code → kolom dari tabel categories
                 $cat->books_count → hasil withCount() Eloquent --}}
            <a href="{{ route('books.index', ['category' => $cat->name]) }}"
               class="p-3 rounded-xl bg-gray-50 hover:bg-[#eff4ff] border border-gray-100 hover:border-emerald-200 transition-all flex flex-col">
                <span class="text-[10px] font-mono font-bold text-emerald-800 bg-white border border-gray-200 px-1.5 py-0.5 rounded w-max mb-1.5">
                    DDC {{ $cat->ddc_code }}
                </span>
                <span class="font-headline font-bold text-xs text-gray-900">{{ $cat->name }}</span>
                <span class="text-[11px] text-gray-500 mt-1">{{ $cat->books_count }} judul</span>
            </a>
            @endforeach
        </div>
    </div>

</div>

<script>
    function showScanAlert() {
        const el = document.getElementById('scanBarcodeAlert');
        el.classList.remove('hidden');
        setTimeout(() => el.classList.add('hidden'), 4000);
    }
</script>
@endsection
