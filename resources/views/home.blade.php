@extends('layouts.public')

@section('title', 'Beranda')

@section('content')
<div class="space-y-16 sm:space-y-24">

    {{-- =========================================================================
         1. HERO SECTION WITH DIRECT OPAC SEARCH
    ========================================================================= --}}
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-forest via-[#163829] to-[#0d241a] text-white p-6 sm:p-12 lg:p-16 shadow-lg">
        <!-- Subtle decorative glow -->
        <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-[#2373F4]/20 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-80 h-80 rounded-full bg-emerald-500/10 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-3xl mx-auto text-center space-y-6">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs text-emerald-200">
                <span class="w-2 h-2 rounded-full bg-[#2373F4]"></span>
                <span>Pusat Literasi &amp; Repositori Akademik</span>
            </div>

            <h1 class="font-headline text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                Pusat Literasi, Riset Ilmiah &amp; Koleksi Digital
            </h1>

            <p class="text-sm sm:text-base text-emerald-100/85 max-w-2xl mx-auto leading-relaxed">
                Layanan perpustakaan terpadu untuk pencarian buku fisik, arsip karya ilmiah sivitas akademika, jurnal rujukan, serta koleksi e-book interaktif.
            </p>

            <!-- Direct OPAC Catalog Search Bar -->
            <form action="{{ route('books.index') }}" method="GET" class="pt-2">
                <div class="bg-white p-2 rounded-2xl shadow-xl flex flex-col sm:flex-row items-center gap-2 border border-white/20">
                    <div class="relative flex-1 w-full flex items-center">
                        <span class="material-symbols-outlined text-slate-400 pl-3.5 pr-2 text-[22px]">search</span>
                        <input type="text"
                               name="search"
                               placeholder="Cari judul buku, penulis, topik, atau nomor ISBN..."
                               class="w-full py-2.5 pr-3 text-xs sm:text-sm text-text-primary placeholder:text-text-muted focus:outline-none bg-transparent">
                    </div>
                    <button type="submit"
                            class="w-full sm:w-auto px-6 py-3 rounded-xl bg-[#2373F4] hover:bg-[#1A5EC4] text-white font-semibold text-xs sm:text-sm shadow-xs transition-all flex items-center justify-center gap-2 shrink-0 cursor-pointer">
                        <span class="material-symbols-outlined text-[18px]">travel_explore</span>
                        <span>Cari di OPAC</span>
                    </button>
                </div>
            </form>

            <div class="pt-2 flex flex-wrap items-center justify-center gap-4 sm:gap-8 text-xs text-emerald-200/80">
                <span class="flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px] text-emerald-400">menu_book</span>
                    <span>{{ $collection['titles'] }} Judul Buku Katalog</span>
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px] text-[#2373F4]">auto_stories</span>
                    <span>{{ $collection['ebooks'] }} Koleksi E-Book</span>
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px] text-amber-400">verified_user</span>
                    <span>Sirkulasi &amp; Peminjaman Mandiri</span>
                </span>
            </div>
        </div>
    </section>

    {{-- =========================================================================
         2. KOMPONEN CARD (LAYANAN UTAMA PERPUSTAKAAN) - FROM FLOWCHART BRANCH
    ========================================================================= --}}
    <section class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 border-b border-border-light pb-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#2373F4]"></span>
                    <span class="text-xs uppercase font-bold tracking-wider text-[#2373F4]">Layanan Unggulan</span>
                </div>
                <h2 class="font-headline text-2xl sm:text-3xl font-extrabold text-text-primary mt-1">
                    Layanan Utama Perpustakaan
                </h2>
                <p class="text-xs sm:text-sm text-text-secondary mt-1">
                    Akses cepat ke katalog buku (OPAC), repositori karya ilmiah, e-journal, CJS per program studi, dan koleksi e-book.
                </p>
            </div>
        </div>

        <!-- 5 Cards Grid as defined in Flowchart -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            {{-- Card 1: Katalog / OPAC --}}
            <a href="{{ route('books.index') }}"
               class="bg-white p-5 rounded-2xl border border-border-light shadow-xs hover:shadow-md hover:border-[#2373F4]/50 transition-all group flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-forest/10 text-forest flex items-center justify-center mb-4 group-hover:bg-[#2373F4] group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-[26px]">manage_search</span>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#2373F4] block mb-1">Katalog Koleksi</span>
                    <h3 class="font-headline font-bold text-base text-text-primary group-hover:text-[#2373F4] transition-colors">
                        Katalog / OPAC
                    </h3>
                    <p class="text-xs text-text-secondary mt-1.5 leading-relaxed">
                        Pencarian lokasi buku fisik, status ketersediaan di rak, nomor panggil DDC, dan nomor ISBN.
                    </p>
                </div>
                <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-forest group-hover:text-[#2373F4]">
                    <span>Buka Katalog</span>
                    <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </div>
            </a>

            {{-- Card 2: Repository MNCU --}}
            @if(config('library.links.repository'))
                <a href="{{ config('library.links.repository') }}" target="_blank" rel="noopener noreferrer"
                   class="bg-white p-5 rounded-2xl border border-border-light shadow-xs hover:shadow-md hover:border-[#2373F4]/50 transition-all group flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-[#2373F4]/10 text-[#2373F4] flex items-center justify-center mb-4 group-hover:bg-[#2373F4] group-hover:text-white transition-colors">
                            <span class="material-symbols-outlined text-[26px]">inventory_2</span>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-text-muted block mb-1">Karya Ilmiah</span>
                        <h3 class="font-headline font-bold text-base text-text-primary group-hover:text-[#2373F4] transition-colors">
                            Repository
                        </h3>
                        <p class="text-xs text-text-secondary mt-1.5 leading-relaxed">
                            Arsip digital skripsi, tesis, laporan tugas akhir, dan publikasi penelitian sivitas akademika.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-[#2373F4]">
                        <span>Buka Repository</span>
                        <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                    </div>
                </a>
            @else
                <div class="bg-white p-5 rounded-2xl border border-border-light shadow-xs flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-[26px]">inventory_2</span>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-text-muted block mb-1">Karya Ilmiah</span>
                        <h3 class="font-headline font-bold text-base text-text-primary">Repository</h3>
                        <p class="text-xs text-text-secondary mt-1.5 leading-relaxed">
                            Arsip digital skripsi, tesis, dan penelitian sivitas akademika institusi.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100">
                        <span class="text-[11px] text-text-muted italic flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">link_off</span>
                            <span>Tautan repository eksternal</span>
                        </span>
                    </div>
                </div>
            @endif

            {{-- Card 3: E-Journal MNCU --}}
            @if(config('library.links.ejournal'))
                <a href="{{ config('library.links.ejournal') }}" target="_blank" rel="noopener noreferrer"
                   class="bg-white p-5 rounded-2xl border border-border-light shadow-xs hover:shadow-md hover:border-[#2373F4]/50 transition-all group flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center mb-4 group-hover:bg-[#2373F4] group-hover:text-white transition-colors">
                            <span class="material-symbols-outlined text-[26px]">article</span>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 block mb-1">Jurnal Riset</span>
                        <h3 class="font-headline font-bold text-base text-text-primary group-hover:text-[#2373F4] transition-colors">
                            E-Journal
                        </h3>
                        <p class="text-xs text-text-secondary mt-1.5 leading-relaxed">
                            Portal terakreditasi jurnal elektronik untuk sitasi dan tinjauan literatur ilmiah.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-emerald-700 group-hover:text-[#2373F4]">
                        <span>Buka E-Journal</span>
                        <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                    </div>
                </a>
            @else
                <div class="bg-white p-5 rounded-2xl border border-border-light shadow-xs flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-[26px]">article</span>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-text-muted block mb-1">Jurnal Riset</span>
                        <h3 class="font-headline font-bold text-base text-text-primary">E-Journal</h3>
                        <p class="text-xs text-text-secondary mt-1.5 leading-relaxed">
                            Portal jurnal elektronik untuk sitasi dan tinjauan literatur ilmiah.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100">
                        <span class="text-[11px] text-text-muted italic flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">link_off</span>
                            <span>Tautan e-journal eksternal</span>
                        </span>
                    </div>
                </div>
            @endif

            {{-- Card 4: CJS per Prodi --}}
            <a href="{{ route('cjs.index') }}"
               class="bg-white p-5 rounded-2xl border border-border-light shadow-xs hover:shadow-md hover:border-[#2373F4]/50 transition-all group flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center mb-4 group-hover:bg-[#2373F4] group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-[26px]">school</span>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-amber-700 block mb-1">Program Studi</span>
                    <h3 class="font-headline font-bold text-base text-text-primary group-hover:text-[#2373F4] transition-colors">
                        CJS per Prodi
                    </h3>
                    <p class="text-xs text-text-secondary mt-1.5 leading-relaxed">
                        Halaman pemilihan Cambridge Journal System yang disesuaikan per program studi.
                    </p>
                </div>
                <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-amber-700 group-hover:text-[#2373F4]">
                    <span>Pilih Prodi</span>
                    <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </div>
            </a>

            {{-- Card 5: E-Book Digital --}}
            <a href="{{ route('ebooks.index') }}"
               class="bg-white p-5 rounded-2xl border border-border-light shadow-xs hover:shadow-md hover:border-[#2373F4]/50 transition-all group flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-[#2373F4]/10 text-[#2373F4] flex items-center justify-center mb-4 group-hover:bg-[#2373F4] group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-[26px]">auto_stories</span>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#2373F4] block mb-1">Baca Mandiri</span>
                    <h3 class="font-headline font-bold text-base text-text-primary group-hover:text-[#2373F4] transition-colors">
                        E-Book Digital
                    </h3>
                    <p class="text-xs text-text-secondary mt-1.5 leading-relaxed">
                        Koleksi buku digital interaktif siap dibaca langsung dari peramban kapan saja.
                    </p>
                </div>
                <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-[#2373F4]">
                    <span>Baca Sekarang</span>
                    <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </div>
            </a>
        </div>
    </section>

    {{-- =========================================================================
         3. CARD CARD BERITA & 4. ACARA / EVENT (SIDE BY SIDE / DUAL COLUMN)
    ========================================================================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12">

        {{-- Card-card Berita Section --}}
        <section class="space-y-4">
            <div class="flex items-center justify-between border-b border-border-light pb-3">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px] text-[#2373F4]">newspaper</span>
                    <h2 class="font-headline text-xl font-bold text-text-primary">Berita &amp; Informasi</h2>
                </div>
                <a href="{{ route('news.index') }}" class="text-xs font-semibold text-[#2373F4] hover:text-[#1A5EC4] flex items-center gap-1">
                    <span>Semua Berita</span>
                    <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
                </a>
            </div>

            <div class="space-y-3">
                @forelse($latestNews as $item)
                    <article class="bg-white p-4 sm:p-5 rounded-2xl border border-border-light hover:shadow-md transition-shadow group">
                        <div class="flex items-center gap-2 text-[11px] text-text-muted mb-2">
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                <span>{{ $item->published_at->format('d M Y') }}</span>
                            </span>
                            @if($item->author)
                                <span>&bull;</span>
                                <span>{{ $item->author->name }}</span>
                            @endif
                        </div>
                        <h3 class="font-headline font-bold text-sm sm:text-base text-text-primary group-hover:text-[#2373F4] transition-colors line-clamp-2">
                            <a href="{{ route('news.show', $item) }}">{{ $item->title }}</a>
                        </h3>
                        <p class="text-xs text-text-secondary mt-1.5 line-clamp-2 leading-relaxed">
                            {{ $item->excerpt }}
                        </p>
                        <div class="pt-3 mt-3 border-t border-slate-100 flex items-center justify-between">
                            <a href="{{ route('news.show', $item) }}" class="text-xs font-semibold text-[#2373F4] hover:underline flex items-center gap-1">
                                <span>Lihat Detail Berita</span>
                                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="bg-white p-8 rounded-2xl border border-border-light text-center space-y-2">
                        <span class="material-symbols-outlined text-4xl text-slate-300">feed</span>
                        <p class="text-xs font-medium text-text-secondary">Belum ada pengumuman berita terbaru.</p>
                        @auth
                            @if(auth()->user()->isLibrarian())
                                <a href="{{ route('news.create') }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-[#2373F4] text-white text-xs font-semibold mt-2">
                                    <span class="material-symbols-outlined text-[16px]">add</span>
                                    <span>Tulis Berita Baru</span>
                                </a>
                            @endif
                        @endauth
                    </div>
                @endforelse
            </div>
        </section>

        {{-- Acara / Event Section --}}
        <section class="space-y-4">
            <div class="flex items-center justify-between border-b border-border-light pb-3">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px] text-emerald-700">event</span>
                    <h2 class="font-headline text-xl font-bold text-text-primary">Agenda &amp; Kegiatan Literasi</h2>
                </div>
                <a href="{{ route('events.index') }}" class="text-xs font-semibold text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
                    <span>Semua Agenda</span>
                    <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
                </a>
            </div>

            <div class="space-y-3">
                @forelse($upcomingEvents as $evt)
                    <article class="bg-white p-4 sm:p-5 rounded-2xl border border-border-light hover:shadow-md transition-shadow group flex items-start gap-4">
                        <!-- Date Badge -->
                        <div class="w-14 sm:w-16 rounded-xl bg-forest text-white p-2 text-center shrink-0">
                            <span class="block text-[10px] uppercase font-bold text-emerald-300">{{ $evt->starts_at->format('M') }}</span>
                            <span class="block text-xl font-extrabold leading-none my-0.5">{{ $evt->starts_at->format('d') }}</span>
                            <span class="block text-[9px] text-emerald-200/80">{{ $evt->starts_at->format('Y') }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[13px]">pin_drop</span>
                                <span class="truncate">{{ $evt->location }}</span>
                            </span>
                            <h3 class="font-headline font-bold text-sm sm:text-base text-text-primary group-hover:text-[#2373F4] transition-colors truncate mt-0.5">
                                <a href="{{ route('events.show', $evt) }}">{{ $evt->title }}</a>
                            </h3>
                            <p class="text-xs text-text-secondary mt-1 line-clamp-2 leading-relaxed">
                                {{ Str::limit($evt->description, 100) }}
                            </p>
                            <a href="{{ route('events.show', $evt) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-[#2373F4] hover:underline mt-2">
                                <span>Lihat Detail Agenda</span>
                                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="bg-white p-8 rounded-2xl border border-border-light text-center space-y-2">
                        <span class="material-symbols-outlined text-4xl text-slate-300">event_busy</span>
                        <p class="text-xs font-medium text-text-secondary">Tidak ada agenda yang dijadwalkan dalam waktu dekat.</p>
                        @auth
                            @if(auth()->user()->isLibrarian())
                                <a href="{{ route('events.create') }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-forest text-white text-xs font-semibold mt-2">
                                    <span class="material-symbols-outlined text-[16px]">add</span>
                                    <span>Jadwalkan Acara Baru</span>
                                </a>
                            @endif
                        @endauth
                    </div>
                @endforelse
            </div>
        </section>

    </div>

    {{-- =========================================================================
         5. MENAMPILKAN STATISTIK PENGUNJUNG - FROM FLOWCHART BRANCH
    ========================================================================= --}}
    <section class="bg-white rounded-3xl p-6 sm:p-10 border border-border-light shadow-xs space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <span class="text-xs uppercase font-bold tracking-wider text-[#15803d]">Statistik Kunjungan &amp; Koleksi</span>
                </div>
                <h2 class="font-headline text-2xl font-extrabold text-text-primary mt-1">
                    Statistik Pengunjung &amp; Koleksi
                </h2>
            </div>
            <span class="text-xs text-text-muted">Data kunjungan dihitung unik per hari secara otomatis.</span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            <!-- Stat 1: Hari Ini -->
            <div class="bg-surface-grey/60 p-4 rounded-2xl border border-border-light/80">
                <div class="flex items-center gap-2 text-text-muted mb-2">
                    <span class="material-symbols-outlined text-[18px] text-[#2373F4]">today</span>
                    <span class="text-xs font-medium">Hari Ini</span>
                </div>
                <div class="text-2xl sm:text-3xl font-extrabold text-text-primary">{{ number_format($visits['today']) }}</div>
                <span class="text-[11px] text-text-muted">kunjungan unik</span>
            </div>

            <!-- Stat 2: Bulan Ini -->
            <div class="bg-surface-grey/60 p-4 rounded-2xl border border-border-light/80">
                <div class="flex items-center gap-2 text-text-muted mb-2">
                    <span class="material-symbols-outlined text-[18px] text-emerald-600">calendar_month</span>
                    <span class="text-xs font-medium">Bulan Ini</span>
                </div>
                <div class="text-2xl sm:text-3xl font-extrabold text-text-primary">{{ number_format($visits['month']) }}</div>
                <span class="text-[11px] text-text-muted">kunjungan unik</span>
            </div>

            <!-- Stat 3: Total Kunjungan -->
            <div class="bg-surface-grey/60 p-4 rounded-2xl border border-border-light/80">
                <div class="flex items-center gap-2 text-text-muted mb-2">
                    <span class="material-symbols-outlined text-[18px] text-amber-600">groups</span>
                    <span class="text-xs font-medium">Total Kunjungan</span>
                </div>
                <div class="text-2xl sm:text-3xl font-extrabold text-text-primary">{{ number_format($visits['total']) }}</div>
                <span class="text-[11px] text-text-muted">sejak sistem aktif</span>
            </div>

            <!-- Stat 4: Judul Buku -->
            <div class="bg-surface-grey/60 p-4 rounded-2xl border border-border-light/80">
                <div class="flex items-center gap-2 text-text-muted mb-2">
                    <span class="material-symbols-outlined text-[18px] text-forest">menu_book</span>
                    <span class="text-xs font-medium">Koleksi Judul</span>
                </div>
                <div class="text-2xl sm:text-3xl font-extrabold text-text-primary">{{ number_format($collection['titles']) }}</div>
                <span class="text-[11px] text-text-muted">judul terdaftar</span>
            </div>

            <!-- Stat 5: E-Book -->
            <div class="bg-surface-grey/60 p-4 rounded-2xl border border-border-light/80 col-span-2 sm:col-span-1">
                <div class="flex items-center gap-2 text-text-muted mb-2">
                    <span class="material-symbols-outlined text-[18px] text-[#2373F4]">auto_stories</span>
                    <span class="text-xs font-medium">E-Book Digital</span>
                </div>
                <div class="text-2xl sm:text-3xl font-extrabold text-text-primary">{{ number_format($collection['ebooks']) }}</div>
                <span class="text-[11px] text-text-muted">siap dibaca daring</span>
            </div>
        </div>
    </section>

    {{-- =========================================================================
         6. MAP (LOKASI PERPUSTAKAAN) - FROM FLOWCHART BRANCH
    ========================================================================= --}}
    <section class="bg-white rounded-3xl p-6 sm:p-10 border border-border-light shadow-xs space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                    <span class="text-xs uppercase font-bold tracking-wider text-rose-600">Lokasi Fisik Perpustakaan</span>
                </div>
                <h2 class="font-headline text-2xl font-extrabold text-text-primary mt-1">
                    Kunjungi Perpustakaan
                </h2>
            </div>
            <a href="{{ route('pages.contact') }}" class="text-xs font-semibold text-[#2373F4] hover:underline flex items-center gap-1">
                <span>Informasi Kontak Lengkap</span>
                <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">
            <!-- Lokasi Info Card -->
            <div class="bg-surface-grey/60 p-6 rounded-2xl border border-border-light flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <h3 class="font-headline font-bold text-base text-text-primary flex items-center gap-2">
                        <span class="material-symbols-outlined text-[#2373F4]">location_on</span>
                        <span>Alamat Perpustakaan</span>
                    </h3>
                    <p class="text-xs text-text-secondary leading-relaxed">
                        {{ config('library.contact.address') ?: 'Gedung MNC University, Jl. Arteri Kedoya No. 9, Kebon Jeruk, Jakarta Barat, DKI Jakarta 11520' }}
                    </p>

                    <div class="pt-2 space-y-2 text-xs text-text-secondary">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[16px] text-text-muted">schedule</span>
                            <span>{{ config('library.contact.hours') ?: 'Senin - Jumat: 08.00 - 16.30 WIB' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[16px] text-text-muted">call</span>
                            <span>{{ config('library.contact.phone') ?: '+62 21 5366 6444' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[16px] text-text-muted">mail</span>
                            <span>{{ config('library.contact.email') ?: 'perpustakaan@mncuniversity.ac.id' }}</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-border-light">
                    <a href="{{ route('pages.contact') }}" class="w-full py-2.5 rounded-xl bg-forest hover:bg-forest-light text-white text-xs font-semibold flex items-center justify-center gap-1.5 transition-colors">
                        <span class="material-symbols-outlined text-[16px]">map</span>
                        <span>Petunjuk Arah &amp; Kontak Staf</span>
                    </a>
                </div>
            </div>

            <!-- Map Embed Container -->
            <div class="lg:col-span-2 rounded-2xl overflow-hidden border border-border-light h-72 sm:h-80 bg-slate-100 relative">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7639.176983907385!2d106.76078576880916!3d-6.165786488848673!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f755f4008685%3A0xff5d1632dbcc3042!2sMNC%20University!5e0!3m2!1sen!2sid!4v1791854863659!5m2!1sen!2sid"
                    width="100%"
                    height="100%"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="strict-origin-when-cross-origin"
                    title="Peta Lokasi MNC University"
                    class="w-full h-full">
                </iframe>
            </div>
        </div>
    </section>

</div>
@endsection
