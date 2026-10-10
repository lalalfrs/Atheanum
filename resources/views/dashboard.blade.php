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
         HERO / LANDING BANNER: Suasana Klasik Perpustakaan Athenaeum
         Background image arsitektur perpustakaan klasik + deep scholarly overlay
         Semua tombol & fungsionalitas UX dipertahankan 100%
    ───────────────────────────────────────────────────────────────────── --}}
    <div class="relative overflow-hidden rounded-2xl border border-[#00652c]/30 shadow-[0_8px_30px_rgb(0,0,0,0.08)] bg-[#042f1a] text-white">
        <!-- Background Image Arsitektur Perpustakaan Klasik -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1507842229450-7977a4966ad5?auto=format&fit=crop&w=1920&q=80"
                 alt="Athenaeum Library Classical Interior"
                 class="w-full h-full object-cover object-center filter brightness-[0.75] contrast-[1.1] scale-105 transition-transform duration-1000 ease-out hover:scale-100">
            <!-- Layered Gradient Overlay untuk kontras maksimal & nuansa Emerald Khas Athenaeum -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#032514]/95 via-[#064321]/85 to-[#0b1c2e]/90 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#021d10] via-transparent to-transparent opacity-90"></div>
        </div>

        <!-- Foreground Content -->
        <div class="relative z-10 p-6 sm:p-8 lg:p-10 flex flex-col justify-between gap-6">
            <!-- Top Bar: Badge & Tanggal -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-emerald-200 text-xs font-semibold w-max">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="tracking-wide">Athenaeum Scholarly Catalog · DDC System</span>
                </div>
                <div class="flex items-center gap-1.5 text-xs text-emerald-100/90 font-medium bg-black/25 backdrop-blur-md border border-white/10 rounded-xl px-3 py-1.5 self-start sm:self-auto">
                    <span class="material-symbols-outlined text-[16px] text-emerald-300">calendar_today</span>
                    <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>
            </div>

            <!-- Headline & Deskripsi -->
            <div class="max-w-3xl">
                <h1 class="font-headline text-2xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight">
                    Sistem Repositori &amp; Katalog <span class="text-emerald-300 drop-shadow-sm">Athenaeum</span>
                </h1>
                <p class="text-xs sm:text-sm text-emerald-100/90 mt-2 leading-relaxed max-w-2xl">
                    Pusat katalogisasi buku ilmiah, klasifikasi Dewey Decimal (DDC), pemantauan audit rak fisik, serta manajemen sirkulasi perpustakaan berbasis basis data <span class="text-white font-semibold underline decoration-emerald-400 underline-offset-2">SQLite via Eloquent ORM</span>.
                </p>
            </div>

            <!-- Toolbar Aksi Utama & Mini Stat Highlights -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pt-4 border-t border-white/15">
                {{-- Action Buttons --}}
                <div class="flex flex-wrap items-center gap-2.5">
                    {{-- Tombol utama: tambah buku --}}
                    <a href="{{ route('books.create') }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#15803d] hover:bg-[#16a34a] text-white font-semibold text-xs sm:text-sm rounded-xl shadow-md hover:shadow-lg transition-all duration-150 active:scale-95 border border-emerald-400/30">
                        <span class="material-symbols-outlined text-[18px]">add_circle</span>
                        <span>Tambah Buku</span>
                    </a>

                    {{-- Export CSV --}}
                    <a href="{{ route('books.export.csv') }}"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-white/15 hover:bg-white/25 backdrop-blur-md text-white text-xs font-semibold rounded-xl border border-white/20 transition-all shadow-xs">
                        <span class="material-symbols-outlined text-[17px] text-emerald-200">file_download</span>
                        <span>Export CSV</span>
                    </a>

                    {{-- Export SQL Dump --}}
                    <a href="{{ route('books.export.sql') }}"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-white/15 hover:bg-white/25 backdrop-blur-md text-white text-xs font-semibold rounded-xl border border-white/20 transition-all shadow-xs">
                        <span class="material-symbols-outlined text-[17px] text-emerald-200">database</span>
                        <span>Export SQL</span>
                    </a>

                    {{-- Barcode scanner demo --}}
                    <button type="button" onclick="showScanAlert()"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-white/15 hover:bg-white/25 backdrop-blur-md text-white text-xs font-semibold rounded-xl border border-white/20 transition-all shadow-xs cursor-pointer">
                        <span class="material-symbols-outlined text-[17px] text-emerald-200">qr_code_scanner</span>
                        <span>Pindai ISBN</span>
                    </button>
                </div>

                {{-- Live Quick Stat Chips --}}
                <div class="flex items-center gap-2 flex-wrap">
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-black/30 backdrop-blur-md rounded-xl border border-white/10 text-xs">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        <span class="text-emerald-100/80">Koleksi:</span>
                        <strong class="text-white">{{ $stats['total_books'] }} Judul</strong>
                    </div>
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-black/30 backdrop-blur-md rounded-xl border border-white/10 text-xs">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                        <span class="text-blue-100/80">Fisik:</span>
                        <strong class="text-white">{{ $stats['total_physical_stock'] }} Eks</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Notifikasi barcode (tersembunyi, muncul saat tombol di atas diklik) --}}
    <div id="scanBarcodeAlert"
         class="hidden -mt-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center justify-between text-xs shadow-sm">
        <div class="flex items-center gap-2.5">
            <div class="w-7 h-7 rounded-lg bg-emerald-600 text-white flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-[18px]">qr_code</span>
            </div>
            <span><strong>Pemindai Barcode Siap:</strong> Arahkan scanner optik ke barcode ISBN pada kartu sirkulasi buku fisik.</span>
        </div>
        <button onclick="document.getElementById('scanBarcodeAlert').classList.add('hidden')"
                class="text-emerald-700 hover:text-emerald-900 p-1 font-bold">✕</button>
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
