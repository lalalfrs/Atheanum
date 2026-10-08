@extends('layouts.app')

@section('title', 'Klasifikasi Kategori DDC - Athenaeum')
@section('page_category', 'Klasifikasi Kategori')

@section('content')
<div class="flex flex-col w-full space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-1 text-[#6f7a6e] text-[11px] uppercase tracking-wider font-bold">
                <span>Perpustakaan</span>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-[#00652c]">Klasifikasi Kategori DDC</span>
            </div>
            <h1 class="font-headline text-3xl font-bold text-[#121c2a] tracking-tight">
                Klasifikasi &amp; Rak DDC
            </h1>
            <p class="text-xs text-[#6f7a6e]">
                Pengelompokan sistematis buku perpustakaan berdasarkan Dewey Decimal Classification (DDC 23rd Edition).
            </p>
        </div>
    </div>

    <!-- Categories Grid Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($categories as $cat)
        @php
            $matchedBooks = $books->filter(function($b) use ($cat) {
                return stripos($b->category, $cat->name) !== false;
            });
        @endphp
        <div class="bg-white p-5 rounded-2xl shadow-xs border border-[#e6eeff] hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="px-2.5 py-1 rounded-md text-xs font-mono font-bold bg-[#eff4ff] text-[#00652c] border border-[#dee9fc]">
                        DDC {{ $cat->ddc_code }}
                    </span>
                    <span class="text-xs font-semibold text-[#6f7a6e]">
                        {{ $matchedBooks->count() }} Judul Aktif
                    </span>
                </div>

                <h3 class="font-headline text-lg font-bold text-[#121c2a] mb-1">
                    {{ $cat->name }}
                </h3>
                <p class="text-xs text-[#6f7a6e] mb-4 leading-relaxed">
                    {{ $cat->description }}
                </p>

                <!-- Sample book covers -->
                <div class="flex items-center -space-x-2 mb-4 overflow-hidden py-1">
                    @forelse($matchedBooks->take(4) as $b)
                        <img src="{{ $b->cover_url }}" alt="{{ $b->title }}" title="{{ $b->title }}"
                             class="w-8 h-11 object-cover rounded-md ring-2 ring-white shadow-2xs cursor-pointer"
                             onclick="openBookDetailModal({{ $b->id }})">
                    @empty
                        <span class="text-[11px] text-[#6f7a6e] italic">
                            Belum ada eksemplar terdaftar
                        </span>
                    @endforelse
                </div>
            </div>

            <a href="{{ route('books.index', ['category' => $cat->name]) }}"
               class="w-full py-2 bg-[#eff4ff] hover:bg-[#15803d] text-[#00652c] hover:text-white rounded-xl text-xs font-semibold transition-all flex items-center justify-center gap-1 cursor-pointer">
                <span>Lihat Koleksi di Katalog</span>
                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
