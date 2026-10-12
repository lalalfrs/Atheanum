{{--
    dashboard.blade.php
    ───────────────────────────────────────────────────────────────────────
    Data di halaman ini 100% dari Eloquent ORM → SQLite.
    Lihat: app/Http/Controllers/DashboardController.php untuk detail query.
    Database file: database/database.sqlite
--}}
@extends('layouts.app')

@section('title', 'Dashboard · Book Library')
@section('page_category', 'Dashboard')

@section('content')
<div class="flex flex-col w-full gap-8">

    {{-- ─────────────────────────────────────────────────────────────────
         DISCOVER / HERO SECTION
         Matches brief: "Discover" header with search bar + category dropdown
    ───────────────────────────────────────────────────────────────────── --}}
    <div>
        {{-- Greeting --}}
        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-text-primary tracking-tight">
                Discover
            </h1>
            <p class="text-sm text-text-secondary mt-1">
                @if(auth()->check() && auth()->user()->isLibrarian())
                    Selamat datang kembali, {{ auth()->user()->name }}. Kelola katalog buku, audit rak, dan pantau sirkulasi perpustakaan.
                @else
                    Temukan koleksi buku pilihan dan jelajahi perpustakaan digital kami.
                @endif
            </p>
        </div>

        {{-- Search Bar with Category Dropdown --}}
        <form method="GET" action="{{ route('books.index') }}" class="flex flex-col sm:flex-row items-stretch gap-2 sm:gap-0 max-w-2xl">
            <div class="relative flex-shrink-0">
                <select name="category" class="w-full sm:w-auto h-11 sm:h-full appearance-none bg-white border border-border-light sm:border-r-0 rounded-xl sm:rounded-l-2xl sm:rounded-r-none px-4 pr-8 text-xs font-medium text-text-secondary focus:outline-none focus:border-forest cursor-pointer">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                <span class="material-symbols-outlined text-[16px] text-text-muted absolute right-3 sm:right-2 top-1/2 -translate-y-1/2 pointer-events-none">expand_more</span>
            </div>
            <div class="flex items-stretch flex-1">
                <input type="text" name="search" placeholder="Cari judul buku, penulis, ISBN..."
                       class="flex-1 px-4 py-2.5 sm:py-3 bg-white border border-border-light rounded-l-xl sm:rounded-none text-xs sm:text-sm text-text-primary placeholder:text-text-muted focus:outline-none focus:border-forest">
                <button type="submit" class="px-4 sm:px-6 py-2.5 sm:py-3 bg-forest hover:bg-forest-light text-white font-semibold text-xs sm:text-sm rounded-r-xl sm:rounded-r-2xl sm:rounded-l-none transition-colors flex items-center justify-center gap-1.5 flex-shrink-0 cursor-pointer">
                    <span class="material-symbols-outlined text-[18px]">search</span>
                    <span>Cari</span>
                </button>
            </div>
        </form>
    </div>

    {{-- ─────────────────────────────────────────────────────────────────
         BOOK RECOMMENDATIONS (Horizontal covers)
         Matches brief: "4 horizontal book covers with recommendations"
    ───────────────────────────────────────────────────────────────────── --}}
    <div>
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-base sm:text-lg font-bold text-text-primary">Book Recommendations</h2>
                <p class="text-[11px] sm:text-xs text-text-secondary">Koleksi terbaru yang direkomendasikan untuk Anda</p>
            </div>
            <a href="{{ route('books.index') }}"
               class="text-xs font-semibold text-forest hover:text-forest-light flex items-center gap-1 transition-colors">
                <span>Lihat Semua</span>
                <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
            @foreach($recentBooks as $book)
            <div class="group relative flex flex-col justify-between">
                <div>
                    <div class="relative overflow-hidden rounded-xl sm:rounded-2xl aspect-[3/4] max-h-[190px] sm:max-h-none bg-surface-grey shadow-xs">
                        <img src="{{ $book->cover_url }}"
                             alt="{{ $book->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        {{-- Overlay gradient --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        {{-- Hover / click action --}}
                        <div class="absolute bottom-2 left-2 right-2 sm:bottom-3 sm:left-3 sm:right-3 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-2 group-hover:translate-y-0">
                            <button type="button" onclick="openBookDetailModal({{ $book->id }})"
                                    class="w-full py-1.5 sm:py-2 bg-white/95 backdrop-blur-sm text-text-primary text-[11px] sm:text-xs font-semibold rounded-lg sm:rounded-xl flex items-center justify-center gap-1 hover:bg-white transition-colors cursor-pointer shadow-xs">
                                <span class="material-symbols-outlined text-[14px] sm:text-[15px]">visibility</span>
                                <span>Lihat Detail</span>
                            </button>
                        </div>
                        {{-- Badges --}}
                        <div class="absolute top-1.5 right-1.5 sm:top-2 sm:right-2 flex flex-col gap-1 items-end">
                            @if($book->is_ebook)
                                <span class="px-1.5 sm:px-2 py-0.5 rounded-md sm:rounded-lg text-[9px] sm:text-[10px] font-bold bg-[#2373F4]/90 backdrop-blur-sm text-white">E-Book</span>
                            @endif
                            @if($book->status === 'Tersedia')
                                <span class="px-1.5 sm:px-2 py-0.5 rounded-md sm:rounded-lg text-[9px] sm:text-[10px] font-bold bg-forest/90 backdrop-blur-sm text-white">Tersedia</span>
                            @elseif($book->status === 'Stok Kritis')
                                <span class="px-1.5 sm:px-2 py-0.5 rounded-md sm:rounded-lg text-[9px] sm:text-[10px] font-bold bg-amber-500/90 backdrop-blur-sm text-white">Kritis</span>
                            @else
                                <span class="px-1.5 sm:px-2 py-0.5 rounded-md sm:rounded-lg text-[9px] sm:text-[10px] font-bold bg-red-500/90 backdrop-blur-sm text-white">Habis</span>
                            @endif
                        </div>
                    </div>
                    <div class="mt-2 sm:mt-3 px-0.5">
                        <span class="text-[9px] sm:text-[10px] font-bold text-coral uppercase tracking-wider">{{ $book->category }}</span>
                        <h3 class="font-bold text-xs sm:text-sm text-text-primary line-clamp-1 mt-0.5" title="{{ $book->title }}">{{ $book->title }}</h3>
                        <p class="text-[11px] sm:text-xs text-text-secondary line-clamp-1">{{ $book->author }}</p>
                    </div>
                </div>
                {{-- Mobile quick detail button --}}
                <div class="mt-2 sm:hidden">
                    <button type="button" onclick="openBookDetailModal({{ $book->id }})"
                            class="w-full py-1 bg-surface-grey hover:bg-cream-dark text-text-primary text-[10px] font-semibold rounded-lg flex items-center justify-center gap-1 transition-colors border border-border-light cursor-pointer">
                        <span class="material-symbols-outlined text-[13px]">visibility</span>
                        <span>Detail</span>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ─────────────────────────────────────────────────────────────────
         SUPER ADMIN WIDGET (Hanya tampil untuk Super Admin)
    ───────────────────────────────────────────────────────────────────── --}}
    @if(auth()->check() && auth()->user()->isSuperAdmin())
    <div class="bg-forest rounded-2xl p-5 text-white flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-white/15 flex items-center justify-center">
                <span class="material-symbols-outlined text-[28px]">admin_panel_settings</span>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="font-bold text-base">Panel Super Administrator</h2>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-coral text-white uppercase">Super Admin</span>
                </div>
                <p class="text-xs text-white/70 mt-0.5">
                    Total {{ $userStats['total_users'] }} akun terdaftar ({{ $userStats['librarians'] }} pustakawan, {{ $userStats['members'] }} anggota) · {{ $userStats['total_active_loans'] }} peminjaman aktif.
                </p>
            </div>
        </div>
        <a href="{{ route('users.index') }}"
           class="px-4 py-2.5 bg-white/15 hover:bg-white/25 text-white font-semibold text-xs rounded-xl transition-all flex items-center gap-1.5 self-start">
            <span class="material-symbols-outlined text-[17px]">manage_accounts</span>
            <span>Kelola Pengguna</span>
        </a>
    </div>
    @endif

    {{-- ─────────────────────────────────────────────────────────────────
         STAT CARDS (4 columns)
    ───────────────────────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        {{-- Card 1: Total Judul Buku --}}
        <div class="bg-surface-grey rounded-2xl p-5 flex flex-col gap-3 hover:shadow-sm transition-shadow">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-forest/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px] text-forest">collections_bookmark</span>
                </div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-forest bg-forest/10 px-2 py-0.5 rounded-full">Aktif</span>
            </div>
            <div>
                <p class="text-xs font-medium text-text-muted uppercase tracking-wider mb-1">Total Judul</p>
                <p class="text-3xl font-bold text-text-primary leading-none">
                    {{ $stats['total_books'] }}
                    <span class="text-sm font-normal text-text-muted">judul</span>
                </p>
            </div>
        </div>

        @if(auth()->check() && !auth()->user()->isLibrarian())
            {{-- Card 2 for Member: Active Loans --}}
            <div class="bg-surface-grey rounded-2xl p-5 flex flex-col gap-3 hover:shadow-sm transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="w-10 h-10 rounded-xl bg-coral/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[22px] text-coral">assignment</span>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-coral bg-coral/10 px-2 py-0.5 rounded-full">Maks 3</span>
                </div>
                <div>
                    <p class="text-xs font-medium text-text-muted uppercase tracking-wider mb-1">Pinjaman Aktif</p>
                    <p class="text-3xl font-bold text-text-primary leading-none">
                        {{ $memberLoans->count() }}
                        <span class="text-sm font-normal text-text-muted">buku</span>
                    </p>
                    <a href="{{ route('loans.index') }}" class="text-[11px] text-forest font-semibold hover:underline mt-1.5 inline-block">Lihat daftar pinjaman →</a>
                </div>
            </div>

            {{-- Card 3 for Member: E-Book Digital --}}
            <div class="bg-surface-grey rounded-2xl p-5 flex flex-col gap-3 hover:shadow-sm transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="w-10 h-10 rounded-xl bg-[#2373F4]/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[22px] text-[#2373F4]">devices</span>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#2373F4] bg-[#2373F4]/10 px-2 py-0.5 rounded-full">Digital</span>
                </div>
                <div>
                    <p class="text-xs font-medium text-text-muted uppercase tracking-wider mb-1">Koleksi E-Book</p>
                    <p class="text-3xl font-bold text-text-primary leading-none">
                        {{ $stats['total_ebooks'] }}
                        <span class="text-sm font-normal text-text-muted">judul</span>
                    </p>
                    <p class="text-[11px] text-text-muted mt-1.5">Dapat dibaca langsung online</p>
                </div>
            </div>
        @else
            {{-- Card 2 for Librarian: Physical Stock --}}
            <div class="bg-surface-grey rounded-2xl p-5 flex flex-col gap-3 hover:shadow-sm transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[22px] text-blue-600">menu_book</span>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">Fisik</span>
                </div>
                <div>
                    <p class="text-xs font-medium text-text-muted uppercase tracking-wider mb-1">Eksemplar Fisik</p>
                    <p class="text-3xl font-bold text-text-primary leading-none">
                        {{ $stats['total_physical_stock'] }}
                        <span class="text-sm font-normal text-text-muted">eksemplar</span>
                    </p>
                    <p class="text-[11px] text-text-muted mt-1.5">
                        Tersedia di rak: <strong class="text-forest">{{ $stats['total_available_stock'] }}</strong> buku
                    </p>
                </div>
            </div>

            {{-- Card 3 for Librarian: Critical Stock --}}
            <div class="bg-surface-grey rounded-2xl p-5 flex flex-col gap-3 hover:shadow-sm transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[22px] text-amber-600">warning</span>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full">≤ 3 eks</span>
                </div>
                <div>
                    <p class="text-xs font-medium text-text-muted uppercase tracking-wider mb-1">Stok Kritis</p>
                    <p class="text-3xl font-bold text-amber-600 leading-none">
                        {{ $stats['critical_books_count'] }}
                        <span class="text-sm font-normal text-text-muted">judul</span>
                    </p>
                    <p class="text-[11px] text-text-muted mt-1.5">
                        {{ $stats['out_of_stock_count'] }} judul sudah habis stok
                    </p>
                </div>
            </div>
        @endif

        {{-- Card 4: DDC Categories --}}
        <div class="bg-surface-grey rounded-2xl p-5 flex flex-col gap-3 hover:shadow-sm transition-shadow">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-forest/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px] text-forest">category</span>
                </div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-forest bg-forest/10 px-2 py-0.5 rounded-full">DDC</span>
            </div>
            <div>
                <p class="text-xs font-medium text-text-muted uppercase tracking-wider mb-1">Kategori</p>
                <p class="text-3xl font-bold text-text-primary leading-none">
                    {{ $stats['total_categories'] }}
                    <span class="text-sm font-normal text-text-muted">sektor</span>
                </p>
                <p class="text-[11px] text-text-muted mt-1.5">Klasifikasi Dewey Decimal</p>
            </div>
        </div>
    </div>

    {{-- ─────────────────────────────────────────────────────────────────
         ACTION TOOLBAR (Librarian tools / Member tools)
    ───────────────────────────────────────────────────────────────────── --}}
    <div class="flex flex-wrap items-center gap-2.5">
        @if(auth()->check() && auth()->user()->isLibrarian())
            <a href="{{ route('books.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-forest hover:bg-forest-light text-white font-semibold text-xs rounded-xl shadow-sm transition-all">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                <span>Tambah Buku</span>
            </a>
            <a href="{{ route('books.export.csv') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-surface-grey hover:bg-cream-dark text-text-secondary text-xs font-semibold rounded-xl border border-border-light transition-all">
                <span class="material-symbols-outlined text-[17px]">file_download</span>
                <span>Export CSV</span>
            </a>
            <a href="{{ route('books.export.sql') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-surface-grey hover:bg-cream-dark text-text-secondary text-xs font-semibold rounded-xl border border-border-light transition-all">
                <span class="material-symbols-outlined text-[17px]">database</span>
                <span>Export SQL</span>
            </a>
            <button type="button" onclick="showScanAlert()"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-surface-grey hover:bg-cream-dark text-text-secondary text-xs font-semibold rounded-xl border border-border-light transition-all cursor-pointer">
                <span class="material-symbols-outlined text-[17px]">qr_code_scanner</span>
                <span>Pindai ISBN</span>
            </button>
        @else
            <a href="{{ route('books.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-forest hover:bg-forest-light text-white font-semibold text-xs rounded-xl shadow-sm transition-all">
                <span class="material-symbols-outlined text-[18px]">menu_book</span>
                <span>Jelajahi Katalog</span>
            </a>
            <a href="{{ route('ebooks.index') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-surface-grey hover:bg-cream-dark text-text-secondary text-xs font-semibold rounded-xl border border-border-light transition-all">
                <span class="material-symbols-outlined text-[17px]">devices</span>
                <span>Koleksi E-Book</span>
            </a>
            @auth
            <a href="{{ route('loans.index') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-surface-grey hover:bg-cream-dark text-text-secondary text-xs font-semibold rounded-xl border border-border-light transition-all">
                <span class="material-symbols-outlined text-[17px]">assignment_return</span>
                <span>Pinjaman Saya</span>
            </a>
            @endauth
        @endif
    </div>

    {{-- Barcode notification (hidden, appears on click) --}}
    <div id="scanBarcodeAlert"
         class="hidden -mt-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl flex items-center justify-between text-xs">
        <div class="flex items-center gap-2.5">
            <div class="w-7 h-7 rounded-lg bg-forest text-white flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-[18px]">qr_code</span>
            </div>
            <span><strong>Pemindai Barcode Siap:</strong> Arahkan scanner optik ke barcode ISBN pada kartu sirkulasi buku fisik.</span>
        </div>
        <button onclick="document.getElementById('scanBarcodeAlert').classList.add('hidden')"
                class="text-green-700 hover:text-green-900 p-1 font-bold">✕</button>
    </div>

    {{-- ─────────────────────────────────────────────────────────────────
         MEMBER ACTIVE LOANS
    ───────────────────────────────────────────────────────────────────── --}}
    @if(auth()->check() && !auth()->user()->isLibrarian() && $memberLoans->isNotEmpty())
    <div class="bg-surface-grey rounded-2xl p-5">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-forest text-[24px]">bookmark_added</span>
                <div>
                    <h2 class="text-base font-bold text-text-primary">Buku yang Sedang Anda Pinjam</h2>
                    <p class="text-xs text-text-secondary">Pastikan mengembalikan tepat waktu sebelum tanggal jatuh tempo</p>
                </div>
            </div>
            <a href="{{ route('loans.index') }}" class="text-xs font-bold text-forest hover:underline">
                Lihat Semua ({{ $memberLoans->count() }}) →
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($memberLoans as $loan)
            <div class="p-4 rounded-2xl bg-white border border-border-light flex flex-col justify-between gap-3">
                <div class="flex gap-3">
                    <img src="{{ $loan->book->cover_url }}" alt="{{ $loan->book->title }}" class="w-12 h-16 object-cover rounded-lg flex-shrink-0 shadow-sm">
                    <div>
                        <span class="text-[10px] font-bold text-coral uppercase">{{ $loan->book->category }}</span>
                        <h4 class="font-bold text-xs text-text-primary line-clamp-1">{{ $loan->book->title }}</h4>
                        <p class="text-[11px] text-text-secondary">{{ $loan->book->author }}</p>
                        <div class="mt-1 flex items-center gap-1.5 text-[11px]">
                            <span class="material-symbols-outlined text-[13px] {{ $loan->isOverdue() ? 'text-rose-600' : 'text-amber-600' }}">event</span>
                            <span class="{{ $loan->isOverdue() ? 'text-rose-700 font-bold' : 'text-amber-800 font-medium' }}">
                                Batas: {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}
                                @if($loan->isOverdue())
                                    <span class="text-rose-600">(Terlambat {{ $loan->overdue_days }} hari)</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <form method="POST" action="{{ route('loans.return', $loan) }}" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full py-1.5 bg-forest hover:bg-forest-light text-white font-semibold text-xs rounded-xl transition-colors flex items-center justify-center gap-1 cursor-pointer">
                            <span class="material-symbols-outlined text-[15px]">assignment_turned_in</span>
                            <span>Kembalikan Buku</span>
                        </button>
                    </form>
                    @if(! $loan->isOverdue() && $loan->renewed_count < 1)
                    <form method="POST" action="{{ route('loans.renew', $loan) }}">
                        @csrf
                        <button type="submit" title="Perpanjang masa pinjam 7 hari" class="px-2.5 py-1.5 bg-[#2373F4]/10 hover:bg-[#2373F4]/20 text-[#2373F4] font-semibold text-xs rounded-xl transition-colors flex items-center justify-center gap-1 cursor-pointer">
                            <span class="material-symbols-outlined text-[14px]">update</span>
                            <span>+7 Hari</span>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ─────────────────────────────────────────────────────────────────
         E-BOOK DIGITAL HIGHLIGHT
    ───────────────────────────────────────────────────────────────────── --}}
    @if($featuredEbooks->isNotEmpty())
    <div class="bg-surface-grey rounded-2xl p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#2373F4]/10 text-[#2373F4] flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">devices</span>
                </div>
                <div>
                    <h3 class="font-bold text-base text-text-primary">Perpustakaan E-Book Digital</h3>
                    <p class="text-xs text-text-secondary">Baca literatur klasik dan modern secara instan</p>
                </div>
            </div>
            <a href="{{ route('ebooks.index') }}" class="text-xs font-bold text-forest hover:text-forest-light flex items-center gap-1">
                Jelajahi Semua E-Book
                <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            @foreach($featuredEbooks as $ebook)
            <div class="bg-white rounded-xl sm:rounded-2xl border border-border-light p-2.5 sm:p-3.5 flex flex-col justify-between hover:shadow-md transition-all group">
                <div>
                    <div class="relative overflow-hidden rounded-lg sm:rounded-xl aspect-[3/4] max-h-[170px] sm:max-h-none mb-2 sm:mb-2.5 bg-surface-grey">
                        <img src="{{ $ebook->cover_url }}" alt="{{ $ebook->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <span class="absolute bottom-1.5 left-1.5 sm:bottom-2 sm:left-2 px-1.5 sm:px-2 py-0.5 rounded-md sm:rounded-lg text-[9px] sm:text-[10px] font-bold bg-black/60 backdrop-blur-sm text-white">
                            {{ $ebook->ebook_pages ?? 120 }} Hal
                        </span>
                    </div>
                    <span class="text-[9px] sm:text-[10px] font-bold text-[#2373F4] uppercase tracking-wider block mb-0.5">{{ $ebook->category }}</span>
                    <h4 class="font-bold text-xs text-text-primary line-clamp-1" title="{{ $ebook->title }}">{{ $ebook->title }}</h4>
                    <p class="text-[11px] text-text-secondary line-clamp-1">{{ $ebook->author }}</p>
                </div>
                <a href="{{ route('ebooks.show', $ebook) }}"
                   class="mt-2.5 sm:mt-3 w-full py-1.5 bg-[#2373F4]/10 hover:bg-[#2373F4] hover:text-white text-[#2373F4] font-semibold text-[11px] sm:text-xs rounded-lg sm:rounded-xl transition-colors flex items-center justify-center gap-1.5">
                    <span class="material-symbols-outlined text-[14px] sm:text-[15px]">auto_stories</span>
                    <span>Baca E-Book</span>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ─────────────────────────────────────────────────────────────────
         BOOK CATEGORIES (DDC Distribution)
         Matches brief: "4 covers with labels on light gray background"
    ───────────────────────────────────────────────────────────────────── --}}
    <div>
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-bold text-base text-text-primary">Book Categories</h3>
                <p class="text-xs text-text-secondary">Klasifikasi koleksi menurut standar Dewey Decimal</p>
            </div>
            @if(auth()->check() && auth()->user()->isLibrarian())
            <a href="{{ route('categories.index') }}"
               class="text-xs font-bold text-forest hover:underline">
                Kelola →
            </a>
            @endif
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2.5 sm:gap-3">
            @foreach($categories as $cat)
            <a href="{{ route('books.index', ['category' => $cat->name]) }}"
               class="p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-surface-grey hover:bg-cream border border-border-light hover:border-coral/30 transition-all flex flex-col gap-1.5 sm:gap-2 group">
                <span class="text-[9px] sm:text-[10px] font-mono font-bold text-forest bg-white border border-border-light px-1.5 py-0.5 rounded-lg w-max">
                    DDC {{ $cat->ddc_code }}
                </span>
                <span class="font-bold text-xs text-text-primary group-hover:text-forest transition-colors line-clamp-1">{{ $cat->name }}</span>
                <span class="text-[10px] sm:text-[11px] text-text-muted">{{ $cat->books_count }} judul</span>
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
