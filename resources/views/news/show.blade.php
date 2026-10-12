@extends('layouts.public')

@section('title', $news->title)

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    <!-- Back Button -->
    <div>
        <a href="{{ route('news.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-text-secondary hover:text-[#2373F4] transition-colors">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Kembali ke Semua Berita</span>
        </a>
    </div>

    <!-- Main Article Card -->
    <article class="bg-white p-6 sm:p-12 rounded-3xl border border-border-light shadow-xs space-y-6">
        <div class="space-y-3 border-b border-slate-100 pb-6">
            <div class="flex items-center gap-3 text-xs text-text-muted">
                <span class="px-2.5 py-0.5 rounded-full bg-[#2373F4]/10 text-[#2373F4] font-bold text-[10px] uppercase tracking-wider">
                    Warta Perpustakaan
                </span>
                <span>&bull;</span>
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[15px]">calendar_today</span>
                    <span>{{ $news->published_at->format('d M Y, H:i') }} WIB</span>
                </span>
                @if($news->author)
                    <span>&bull;</span>
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-[15px]">person</span>
                        <span>{{ $news->author->name }}</span>
                    </span>
                @endif
            </div>

            <h1 class="text-2xl sm:text-4xl font-extrabold text-text-primary tracking-tight leading-snug">
                {{ $news->title }}
            </h1>

            <p class="text-sm sm:text-base text-text-secondary font-medium leading-relaxed italic border-l-4 border-[#2373F4] pl-4 py-1">
                {{ $news->excerpt }}
            </p>
        </div>

        <!-- Article Body -->
        <div class="prose max-w-none text-text-primary text-sm sm:text-base leading-relaxed space-y-4 whitespace-pre-line">
            {{ $news->body }}
        </div>

        <!-- Librarian Controls -->
        @auth
            @if(auth()->user()->isLibrarian())
                <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs text-text-muted">Kelola artikel sebagai pustakawan</span>
                    <form method="POST" action="{{ route('news.destroy', $news) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3.5 py-2 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 text-xs font-semibold flex items-center gap-1 transition-colors cursor-pointer">
                            <span class="material-symbols-outlined text-[16px]">delete</span>
                            <span>Hapus Berita</span>
                        </button>
                    </form>
                </div>
            @endif
        @endauth
    </article>

    <!-- Other News Recommendations -->
    @if($otherNews->isNotEmpty())
        <div class="space-y-4 pt-4">
            <h2 class="text-lg font-bold text-text-primary">Berita Lainnya</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach($otherNews as $other)
                    <a href="{{ route('news.show', $other) }}" class="bg-white p-4 rounded-2xl border border-border-light hover:shadow-md transition-shadow group flex flex-col justify-between">
                        <div>
                            <span class="text-[10px] text-text-muted block mb-1">{{ $other->published_at->format('d M Y') }}</span>
                            <h3 class="font-bold text-xs sm:text-sm text-text-primary group-hover:text-[#2373F4] transition-colors line-clamp-2">
                                {{ $other->title }}
                            </h3>
                        </div>
                        <span class="text-xs font-semibold text-[#2373F4] flex items-center gap-1 pt-3 mt-3 border-t border-slate-100">
                            <span>Baca</span>
                            <span class="material-symbols-outlined text-[13px]">arrow_forward</span>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
