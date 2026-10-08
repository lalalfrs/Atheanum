@extends('layouts.app')

@section('title', 'Detail Buku - ' . $book->title)
@section('page_category', 'Detail Buku')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <div class="mb-6 flex items-center justify-between flex-wrap gap-4">
        <div>
            <div class="flex items-center gap-1 text-[#6f7a6e] text-[11px] uppercase tracking-wider font-bold mb-1">
                <a href="{{ route('books.index') }}" class="hover:underline">Katalog Buku</a>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-[#00652c]">{{ $book->category }}</span>
            </div>
            <h1 class="font-headline text-2xl font-bold text-[#121c2a] tracking-tight">
                {{ $book->title }}
            </h1>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('books.index') }}" class="px-3.5 py-2 bg-white hover:bg-gray-50 text-gray-700 text-xs font-semibold rounded-xl border border-gray-200 shadow-xs transition-colors flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                <span>Kembali ke Katalog</span>
            </a>
            <a href="{{ route('books.edit', $book) }}" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold rounded-xl shadow-xs transition-colors flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px]">edit</span>
                <span>Edit Buku</span>
            </a>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="bg-white rounded-2xl border border-[#e6eeff] p-6 sm:p-8 shadow-xs">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Left: Cover & Badges -->
            <div class="flex flex-col items-center">
                <img src="{{ $book->cover_url }}" alt="{{ $book->title }}"
                     class="w-full max-w-[240px] aspect-[3/4] object-cover rounded-2xl shadow-lg border border-gray-100">

                <div class="mt-4 text-center w-full">
                    <span class="px-3 py-1 rounded-full text-xs font-bold inline-block mb-2 {{ $book->status === 'Tersedia' ? 'bg-emerald-100 text-emerald-800' : ($book->status === 'Stok Kritis' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') }}">
                        Status: {{ $book->status }}
                    </span>
                    <span class="text-xs text-gray-400 font-mono block">ISBN: {{ $book->isbn }}</span>
                </div>

                <!-- Stock adjustment inline -->
                <div class="mt-6 p-4 bg-gray-50 rounded-xl border border-gray-100 w-full text-center">
                    <span class="text-xs text-gray-500 font-medium block mb-2">Penyesuaian Cepat Stok Fisik</span>
                    <div class="flex items-center justify-center gap-3">
                        <form method="POST" action="{{ route('books.stock', $book) }}" class="inline">
                            @csrf
                            <button type="submit" name="delta" value="-1"
                                    class="w-9 h-9 rounded-xl bg-white hover:bg-gray-100 text-gray-700 font-bold border border-gray-200 shadow-xs flex items-center justify-center text-sm">
                                -
                            </button>
                        </form>
                        <div class="flex flex-col">
                            <span class="text-2xl font-headline font-bold text-emerald-800">{{ $book->stock }}</span>
                            <span class="text-[10px] text-gray-400">/ {{ $book->total_copies }} eks</span>
                        </div>
                        <form method="POST" action="{{ route('books.stock', $book) }}" class="inline">
                            @csrf
                            <button type="submit" name="delta" value="1"
                                    class="w-9 h-9 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold shadow-xs flex items-center justify-center text-sm">
                                +
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right: Metadata & Specs -->
            <div class="md:col-span-2 flex flex-col justify-between">
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider bg-emerald-50 px-2.5 py-1 rounded-md">
                        {{ $book->category }}
                    </span>
                    <h2 class="font-headline font-bold text-2xl text-gray-900 mt-2">{{ $book->title }}</h2>
                    @if($book->subtitle)
                        <p class="text-sm text-gray-500 italic mt-1">{{ $book->subtitle }}</p>
                    @endif

                    <div class="grid grid-cols-2 gap-3 mt-6">
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                            <span class="text-gray-400 block text-[10px] uppercase font-bold">Penulis</span>
                            <strong class="text-gray-800 text-sm">{{ $book->author }}</strong>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                            <span class="text-gray-400 block text-[10px] uppercase font-bold">Penerbit</span>
                            <strong class="text-gray-800 text-sm">{{ $book->publisher }}</strong>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                            <span class="text-gray-400 block text-[10px] uppercase font-bold">Tahun Terbit</span>
                            <strong class="text-gray-800 text-sm">{{ $book->year }}</strong>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                            <span class="text-gray-400 block text-[10px] uppercase font-bold">Lokasi Rak</span>
                            <strong class="text-gray-800 text-sm">{{ $book->shelf_location }}</strong>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Deskripsi &amp; Sinopsis:</h4>
                        <div class="p-4 bg-gray-50/60 rounded-xl border border-gray-100 text-xs text-gray-600 leading-relaxed">
                            {{ $book->description ?: 'Belum ada ringkasan atau catatan bibliografi yang tercatat.' }}
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-3 pt-6 mt-6 border-t border-gray-100">
                    <span class="text-[11px] text-gray-400">
                        Diperbarui: {{ $book->updated_at->diffForHumans() }}
                    </span>
                    <button type="button"
                            onclick="openDeleteModal('{{ route('books.destroy', $book) }}', '{{ addslashes($book->title) }}')"
                            class="px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-semibold rounded-xl transition-colors flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px]">delete</span>
                        <span>Hapus Buku</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
