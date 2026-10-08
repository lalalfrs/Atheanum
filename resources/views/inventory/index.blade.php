@extends('layouts.app')

@section('title', 'Laporan Inventaris Fisik & Audit Rak - Athenaeum')
@section('page_category', 'Laporan Inventaris Fisik')

@section('content')
<div class="flex flex-col w-full space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-1 text-[#6f7a6e] text-[11px] uppercase tracking-wider font-bold">
                <span>Perpustakaan</span>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-[#00652c]">Laporan Inventaris Fisik</span>
            </div>
            <h1 class="font-headline text-3xl font-bold text-[#121c2a] tracking-tight">
                Distribusi Fisik &amp; Audit Rak
            </h1>
            <p class="text-xs text-[#6f7a6e]">
                Monitoring fisik eksemplar buku di tiap rak penyimpanan dan status ketersediaan sirkulasi.
            </p>
        </div>
    </div>

    <!-- Shelves List -->
    <div class="space-y-4">
        @foreach($shelves as $shelf)
        <div class="bg-white p-5 rounded-2xl shadow-xs border border-[#e6eeff] flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-[#eff4ff] text-[#00652c] flex items-center justify-center font-bold text-base flex-shrink-0 border border-[#dee9fc]">
                    {{ str_replace('Rak ', '', $shelf['code']) }}
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="font-headline font-bold text-base text-[#121c2a]">
                            {{ $shelf['name'] }}
                        </h3>
                        <span class="text-[11px] text-[#6f7a6e] bg-[#eff4ff] px-2 py-0.5 rounded-md">
                            {{ $shelf['location'] }}
                        </span>
                    </div>
                    <p class="text-xs text-[#6f7a6e] mt-1">
                        {{ count($shelf['books']) }} judul terdaftar • {{ $shelf['total_stock'] }} eksemplar fisik tersedia di rak
                    </p>

                    <div class="flex items-center gap-2 mt-3 flex-wrap">
                        @forelse($shelf['books'] as $b)
                        <button type="button" onclick="openBookDetailModal({{ $b->id }})"
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-[#eff4ff] hover:bg-[#d9e3f6] text-xs text-[#121c2a] font-medium transition-colors border border-[#dee9fc] cursor-pointer">
                            <img src="{{ $b->cover_url }}" alt="{{ $b->title }}" class="w-4 h-5 object-cover rounded shadow-2xs">
                            <span class="truncate max-w-[140px]">{{ $b->title }}</span>
                            <span class="text-[10px] text-[#00652c] font-bold">({{ $b->stock }})</span>
                        </button>
                        @empty
                        <span class="text-[11px] text-gray-400 italic">Belum ada buku ditempatkan di rak ini.</span>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="text-right flex-shrink-0">
                <span class="text-xs text-[#6f7a6e] block">Kapasitas Rak</span>
                <span class="font-headline text-xl font-bold text-[#121c2a]">
                    {{ $shelf['total_stock'] }} / {{ $shelf['capacity'] }}
                </span>
                <div class="w-32 h-1.5 bg-[#eff4ff] rounded-full overflow-hidden mt-1.5 ml-auto">
                    <div class="bg-[#15803d] h-full rounded-full transition-all"
                         style="width: {{ min(100, ($shelf['total_stock'] / $shelf['capacity']) * 100) }}%"></div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
