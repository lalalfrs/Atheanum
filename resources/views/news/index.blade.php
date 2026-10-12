@extends('layouts.public')

@section('title', 'Berita & Informasi')

@section('content')
<div class="space-y-8">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 sm:p-10 rounded-3xl border border-border-light shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#2373F4]"></span>
                <span class="text-xs uppercase font-bold tracking-wider text-[#2373F4]">Warta Perpustakaan</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-text-primary tracking-tight mt-1">
                Berita &amp; Informasi Terkini
            </h1>
            <p class="text-xs sm:text-sm text-text-secondary mt-1">
                Kabar terbaru seputar layanan literasi, fasilitas baru, pengadaan buku, dan agenda akademik.
            </p>
        </div>

        @auth
            @if(auth()->user()->isLibrarian())
                <a href="{{ route('news.create') }}"
                   class="px-4 py-2.5 rounded-xl bg-[#2373F4] hover:bg-[#1A5EC4] text-white text-xs font-semibold shadow-xs flex items-center gap-1.5 shrink-0 transition-colors">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    <span>Tulis Berita Baru</span>
                </a>
            @endif
        @endauth
    </div>

    <!-- News Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($news as $item)
            <article class="bg-white p-6 rounded-3xl border border-border-light shadow-xs hover:shadow-md transition-shadow flex flex-col justify-between group">
                <div class="space-y-3">
                    <div class="flex items-center gap-2 text-xs text-text-muted">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[15px]">calendar_today</span>
                            <span>{{ $item->published_at->format('d M Y') }}</span>
                        </span>
                        @if($item->author)
                            <span>&bull;</span>
                            <span class="truncate">{{ $item->author->name }}</span>
                        @endif
                    </div>

                    <h2 class="font-bold text-base sm:text-lg text-text-primary group-hover:text-[#2373F4] transition-colors line-clamp-2">
                        <a href="{{ route('news.show', $item) }}">{{ $item->title }}</a>
                    </h2>

                    <p class="text-xs text-text-secondary line-clamp-3 leading-relaxed">
                        {{ $item->excerpt }}
                    </p>
                </div>

                <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('news.show', $item) }}" class="text-xs font-semibold text-[#2373F4] hover:underline flex items-center gap-1">
                        <span>Lihat Detail Berita</span>
                        <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
                    </a>
                </div>
            </article>
        @empty
            <div class="col-span-full bg-white p-16 rounded-3xl border border-border-light text-center space-y-3">
                <span class="material-symbols-outlined text-5xl text-slate-300">feed</span>
                <p class="text-base font-semibold text-text-primary">Belum ada artikel berita yang diterbitkan.</p>
                <p class="text-xs text-text-muted">Pantau terus halaman ini untuk pembaruan kegiatan dan informasi perpustakaan.</p>
            </div>
        @endforelse
    </div>

    @if($news->hasPages())
        <div class="p-4 bg-white rounded-2xl border border-border-light">
            {{ $news->links() }}
        </div>
    @endif

</div>
@endsection
