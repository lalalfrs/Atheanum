@extends('layouts.app')

@section('title', 'Koleksi E-Book Digital · Athenaeum Library')
@section('page_category', 'E-Book & Repositori Digital')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-[#e6eeff] shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                <span class="text-xs uppercase font-bold tracking-wider text-[#00652c]">Perpustakaan Digital</span>
            </div>
            <h1 class="font-headline font-bold text-2xl text-[#121c2a] mt-1">
                Koleksi E-Book &amp; Naskah Digital
            </h1>
            <p class="text-xs text-[#6f7a6e] mt-1">
                Akses baca mandiri secara langsung untuk pengunjung, mahasiswa, dan seluruh anggota perpustakaan.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <span class="px-3.5 py-1.5 rounded-xl bg-emerald-50 border border-emerald-200 text-[#00652c] text-xs font-semibold flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[18px]">menu_book</span>
                <span>{{ $ebooks->total() }} E-Book Tersedia</span>
            </span>
        </div>
    </div>

    <!-- Filter & Pencarian -->
    <div class="bg-white p-4 rounded-2xl border border-[#e6eeff] flex flex-col md:flex-row items-center justify-between gap-3 shadow-xs">
        <form method="GET" action="{{ route('ebooks.index') }}" class="w-full flex flex-col sm:flex-row items-center gap-2.5">
            <div class="relative flex-1 w-full">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <span class="material-symbols-outlined text-[18px]">search</span>
                </span>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari judul e-book, topik, atau penulis..."
                       class="w-full pl-9 pr-3 py-2 rounded-xl bg-slate-50 border border-[#dee9fc] text-xs text-[#121c2a] focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
            </div>

            <select name="category"
                    onchange="this.form.submit()"
                    class="w-full sm:w-56 px-3 py-2 rounded-xl bg-slate-50 border border-[#dee9fc] text-xs text-[#121c2a] focus:bg-white focus:outline-none">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>

            <button type="submit"
                    class="px-4 py-2 rounded-xl bg-[#15803d] text-white text-xs font-semibold hover:bg-[#16a34a] transition-colors flex items-center gap-1.5 shrink-0">
                <span class="material-symbols-outlined text-[16px]">filter_alt</span>
                <span>Filter</span>
            </button>

            @if(request()->hasAny(['search', 'category']))
                <a href="{{ route('ebooks.index') }}"
                   class="px-3 py-2 rounded-xl bg-slate-100 text-[#6f7a6e] hover:text-[#121c2a] text-xs font-semibold transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Grid Koleksi E-Book -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-5">
        @forelse($ebooks as $book)
        <div class="bg-white rounded-xl sm:rounded-2xl border border-[#e6eeff] overflow-hidden shadow-xs hover:shadow-md transition-all flex flex-col justify-between group">
            <div>
                <!-- Cover Image & Badge Digital -->
                <div class="relative h-40 sm:h-56 bg-slate-100 overflow-hidden">
                    <img src="{{ $book->cover_url }}"
                         alt="{{ $book->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute top-2 right-2 px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded-md sm:rounded-lg bg-emerald-900/80 backdrop-blur-md text-emerald-200 text-[9px] sm:text-[10px] font-bold uppercase tracking-wider flex items-center gap-1">
                        <span class="material-symbols-outlined text-[12px] sm:text-[14px]">auto_stories</span>
                        <span class="hidden sm:inline">E-Book Digital</span>
                        <span class="sm:hidden">Digital</span>
                    </div>
                </div>

                <!-- Info Buku -->
                <div class="p-2.5 sm:p-4">
                    <span class="text-[9px] sm:text-[10px] uppercase font-bold text-[#00652c] tracking-wider block mb-0.5 sm:mb-1">
                        {{ $book->category }}
                    </span>
                    <h3 class="font-headline font-bold text-xs sm:text-base text-[#121c2a] line-clamp-1 group-hover:text-emerald-700 transition-colors" title="{{ $book->title }}">
                        {{ $book->title }}
                    </h3>
                    <p class="text-[11px] sm:text-xs text-[#6f7a6e] mt-0.5 line-clamp-1">
                        {{ $book->author }} ({{ $book->year }})
                    </p>
                    <p class="text-[11px] sm:text-xs text-slate-500 mt-1.5 sm:mt-2 line-clamp-2 leading-relaxed hidden sm:block">
                        {{ $book->description ?: 'Buku katalog klasik dan ilmiah digital siap dibaca secara daring.' }}
                    </p>
                </div>
            </div>

            <!-- Footer Card & Tombol Baca -->
            <div class="p-2.5 sm:p-4 pt-0 border-t border-slate-100 mt-2 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-1.5 sm:gap-2">
                <span class="text-[10px] sm:text-[11px] text-slate-400 font-mono flex items-center gap-1">
                    <span class="material-symbols-outlined text-[13px] sm:text-[14px]">article</span>
                    <span>{{ $book->ebook_pages ?: 150 }} hal</span>
                </span>
                <a href="{{ route('ebooks.read', $book) }}"
                   class="w-full sm:w-auto px-2.5 sm:px-3.5 py-1.5 sm:py-2 rounded-lg sm:rounded-xl bg-[#15803d] hover:bg-[#16a34a] text-white text-[11px] sm:text-xs font-semibold shadow-xs flex items-center justify-center gap-1 sm:gap-1.5 transition-all">
                    <span class="material-symbols-outlined text-[14px] sm:text-[16px]">menu_book</span>
                    <span>Baca E-Book</span>
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 text-center text-slate-400 bg-white rounded-2xl border border-[#e6eeff]">
            <span class="material-symbols-outlined text-4xl mb-2 block text-slate-300">book_2</span>
            <span class="font-semibold text-sm text-slate-600 block">Belum ada e-book yang cocok</span>
            <p class="text-xs text-slate-400 mt-1">Coba gunakan kata kunci pencarian atau kategori lain.</p>
        </div>
        @endforelse
    </div>

    @if($ebooks->hasPages())
    <div class="p-4 bg-white rounded-2xl border border-[#e6eeff]">
        {{ $ebooks->links() }}
    </div>
    @endif

</div>
@endsection
