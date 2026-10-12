@extends('layouts.app')

@section('title', 'Katalog & Manajemen Buku - Athenaeum')
@section('page_category', 'Sirkulasi & Katalog Buku')

@section('content')
<div class="flex flex-col w-full">
    <!-- Header Halaman & Tombol Aksi -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-1 text-[#6f7a6e] text-[11px] uppercase tracking-wider font-bold mb-1">
                <span>Perpustakaan</span>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-[#00652c]">Sirkulasi &amp; Katalog Buku</span>
            </div>
            <h1 class="font-headline text-2xl sm:text-3xl font-bold text-[#121c2a] tracking-tight">
                Manajemen &amp; Sirkulasi Buku
            </h1>
            <p class="text-xs text-[#6f7a6e] mt-0.5">
                Basis data terpusat koleksi eksemplar, inventaris rak, dan pencatatan sirkulasi perpustakaan.
            </p>
        </div>

        <div class="grid grid-cols-2 sm:flex sm:items-center gap-2 sm:gap-2.5 w-full sm:w-auto">
            <a href="{{ route('books.export.csv') }}"
               class="px-3.5 py-2 bg-white hover:bg-gray-50 text-[#121c2a] rounded-xl text-xs font-semibold border border-[#dee9fc] shadow-xs transition-all flex items-center justify-center gap-1.5">
                <span class="material-symbols-outlined text-[18px] text-[#6f7a6e]">file_download</span>
                <span>Export CSV</span>
            </a>
            @if(auth()->check() && auth()->user()->isLibrarian())
                <a href="{{ route('books.create') }}"
                   class="px-4 py-2 bg-[#15803d] hover:bg-[#00652c] text-white rounded-xl text-xs font-semibold shadow-sm transition-all flex items-center justify-center gap-1.5 active:scale-95">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    <span class="truncate">Tambah Buku</span>
                </a>
            @else
                <a href="{{ route('ebooks.index') }}"
                   class="px-3.5 py-2 bg-[#2373F4]/10 hover:bg-[#2373F4]/20 text-[#2373F4] rounded-xl text-xs font-semibold border border-[#2373F4]/20 shadow-xs transition-all flex items-center justify-center gap-1.5">
                    <span class="material-symbols-outlined text-[18px] text-[#2373F4]">devices</span>
                    <span>Koleksi E-Book</span>
                </a>
                @auth
                <a href="{{ route('loans.index') }}"
                   class="col-span-2 sm:col-span-1 px-3.5 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 rounded-xl text-xs font-semibold border border-emerald-200 shadow-xs transition-all flex items-center justify-center gap-1.5">
                    <span class="material-symbols-outlined text-[18px] text-emerald-600">assignment_return</span>
                    <span>Pinjaman Saya</span>
                </a>
                @endauth
            @endif
        </div>
    </div>

    <!-- Filter & Search Toolbar (Form GET) -->
    <div class="bg-white rounded-xl sm:rounded-2xl p-3.5 sm:p-4 border border-[#e6eeff] shadow-xs mb-5">
        <form method="GET" action="{{ route('books.index') }}" id="filterForm" class="flex flex-col gap-3">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2.5">
                <!-- 1. Text Search Input -->
                <div class="relative col-span-2 sm:col-span-3 lg:col-span-2">
                    <span class="material-symbols-outlined absolute left-3 top-2.5 text-gray-400 text-[18px]">search</span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari judul, ISBN, penulis, atau rak..."
                           class="w-full pl-9 pr-4 py-2 bg-[#eff4ff]/60 border border-[#dee9fc] rounded-lg text-xs outline-none focus:border-emerald-600 focus:bg-white text-gray-900 transition-colors">
                </div>

                <!-- 2. Category Select -->
                <div class="col-span-1">
                    <select name="category" onchange="document.getElementById('filterForm').submit()"
                            class="w-full px-2.5 py-2 bg-[#eff4ff]/60 border border-[#dee9fc] rounded-lg text-xs outline-none focus:border-emerald-600 focus:bg-white text-gray-800 transition-colors cursor-pointer truncate">
                        <option value="Semua Kategori">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->name }}" {{ request('category') == $cat->name ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- 3. Status Select -->
                <div class="col-span-1">
                    <select name="status" onchange="document.getElementById('filterForm').submit()"
                            class="w-full px-2.5 py-2 bg-[#eff4ff]/60 border border-[#dee9fc] rounded-lg text-xs outline-none focus:border-emerald-600 focus:bg-white text-gray-800 transition-colors cursor-pointer truncate">
                        <option value="">Semua Status</option>
                        <option value="Tersedia" {{ request('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia (&gt; 3)</option>
                        <option value="Stok Kritis" {{ request('status') == 'Stok Kritis' ? 'selected' : '' }}>Stok Kritis (&le; 3)</option>
                        <option value="Habis" {{ request('status') == 'Habis' ? 'selected' : '' }}>Habis (0)</option>
                    </select>
                </div>

                <!-- 4. Year Select -->
                <div class="col-span-2 sm:col-span-1">
                    <select name="year" onchange="document.getElementById('filterForm').submit()"
                            class="w-full px-2.5 py-2 bg-[#eff4ff]/60 border border-[#dee9fc] rounded-lg text-xs outline-none focus:border-emerald-600 focus:bg-white text-gray-800 transition-colors cursor-pointer truncate">
                        <option value="">Tahun Terbit</option>
                        <option value="2024" {{ request('year') == '2024' ? 'selected' : '' }}>2024</option>
                        <option value="2023" {{ request('year') == '2023' ? 'selected' : '' }}>2023</option>
                        <option value="2020 - 2022" {{ request('year') == '2020 - 2022' ? 'selected' : '' }}>2020 - 2022</option>
                        <option value="2010 - 2019" {{ request('year') == '2010 - 2019' ? 'selected' : '' }}>2010 - 2019</option>
                        <option value="< 2010" {{ request('year') == '< 2010' ? 'selected' : '' }}>&lt; 2010</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between pt-2.5 border-t border-gray-100 gap-2.5">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-xs text-gray-500">Urutkan:</span>
                    <select name="sort" onchange="document.getElementById('filterForm').submit()"
                            class="px-2.5 py-1 bg-gray-50 border border-gray-200 rounded-md text-xs text-gray-700 outline-none cursor-pointer">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terakhir Diperbarui</option>
                        <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Judul A-Z</option>
                        <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Judul Z-A</option>
                        <option value="stock_desc" {{ request('sort') == 'stock_desc' ? 'selected' : '' }}>Stok Terbanyak</option>
                        <option value="year_desc" {{ request('sort') == 'year_desc' ? 'selected' : '' }}>Tahun Terbaru</option>
                    </select>

                    @if(request()->hasAny(['search', 'category', 'status', 'year', 'sort']))
                    <a href="{{ route('books.index') }}" class="text-xs text-rose-600 hover:text-rose-800 font-medium flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">clear</span>
                        <span>Reset</span>
                    </a>
                    @endif
                </div>

                <div class="flex items-center justify-between sm:justify-end gap-3 w-full sm:w-auto">
                    <span class="text-xs text-gray-500">
                        Total <strong class="text-gray-900">{{ $books->total() }}</strong> judul
                    </span>

                    <!-- Toggle View Mode: Table vs Grid -->
                    <div class="flex items-center bg-gray-100 p-0.5 rounded-lg border border-gray-200">
                        <button type="button" onclick="setViewMode('table')" id="viewModeTableBtn"
                                class="px-2.5 py-1 rounded text-xs font-semibold flex items-center gap-1 bg-white text-emerald-800 shadow-xs">
                            <span class="material-symbols-outlined text-[16px]">view_list</span>
                            <span class="hidden sm:inline">Daftar</span>
                        </button>
                        <button type="button" onclick="setViewMode('grid')" id="viewModeGridBtn"
                                class="px-2.5 py-1 rounded text-xs font-semibold flex items-center gap-1 text-gray-500 hover:text-gray-900">
                            <span class="material-symbols-outlined text-[16px]">grid_view</span>
                            <span class="hidden sm:inline">Grid</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Table & List View Container -->
    <div id="tableViewContainer" class="bg-white rounded-xl sm:rounded-2xl border border-[#e6eeff] shadow-xs overflow-hidden mb-6">
        <!-- 1. Mobile Card List (Visible on screens < md) -->
        <div class="block md:hidden divide-y divide-gray-100">
            @forelse($books as $book)
            <div class="p-3.5 hover:bg-gray-50/50 transition-colors">
                <div class="flex items-start gap-3">
                    <!-- Cover Image -->
                    <div class="relative flex-shrink-0 cursor-pointer group" onclick="openBookDetailModal({{ $book->id }})">
                        <img src="{{ $book->cover_url }}" alt="{{ $book->title }}"
                             class="w-16 h-22 object-cover rounded-xl shadow-xs border border-gray-200 group-hover:scale-102 transition-transform">
                        @if($book->is_ebook)
                            <span class="absolute -top-1.5 -right-1.5 w-5 h-5 rounded-full bg-[#2373F4] text-white flex items-center justify-center shadow-xs text-[10px]" title="E-Book Tersedia">
                                <span class="material-symbols-outlined text-[13px]">devices</span>
                            </span>
                        @endif
                    </div>

                    <!-- Main Book Info -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-1 mb-1">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-[#eff4ff] text-[#00652c] border border-[#dee9fc] truncate max-w-[130px]">
                                {{ $book->category }}
                            </span>
                            <span class="text-[10px] text-gray-400 font-medium flex-shrink-0">Tahun {{ $book->year }}</span>
                        </div>

                        <h3 class="font-headline font-bold text-gray-900 text-sm leading-snug line-clamp-2 hover:text-emerald-700 cursor-pointer"
                            onclick="openBookDetailModal({{ $book->id }})" title="{{ $book->title }}">
                            {{ $book->title }}
                        </h3>
                        @if($book->subtitle)
                            <p class="text-[11px] text-gray-400 italic line-clamp-1 mt-0.5">{{ $book->subtitle }}</p>
                        @endif

                        <p class="text-xs text-gray-600 line-clamp-1 mt-0.5">
                            <span class="font-medium text-gray-800">{{ $book->author }}</span>
                            @if($book->publisher)
                                <span class="text-gray-400">· {{ $book->publisher }}</span>
                            @endif
                        </p>

                        <div class="flex items-center gap-2 mt-1.5">
                            <span class="text-[10px] text-gray-500 font-mono bg-gray-100 px-1.5 py-0.5 rounded border border-gray-200">
                                {{ $book->isbn }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Middle Row: Shelf, Stock, Status -->
                <div class="flex items-center justify-between bg-gray-50/90 rounded-xl px-3 py-2 mt-3 border border-gray-100 flex-wrap gap-2 text-xs">
                    <!-- Shelf location -->
                    <div class="flex items-center gap-1.5 text-gray-700">
                        <span class="material-symbols-outlined text-[16px] text-gray-400">shelves</span>
                        <span class="font-medium text-xs">{{ $book->shelf_location }}</span>
                    </div>

                    <!-- Stock Stepper (Librarian) or Counter (Member) -->
                    <div class="flex items-center gap-2">
                        @if(auth()->check() && auth()->user()->isLibrarian())
                            <div class="inline-flex items-center gap-1 bg-white px-2 py-0.5 rounded-lg border border-gray-200 shadow-2xs">
                                <form method="POST" action="{{ route('books.stock', $book) }}" class="inline">
                                    @csrf
                                    <button type="submit" name="delta" value="-1"
                                            class="w-6 h-6 rounded bg-gray-100 hover:bg-gray-200 active:scale-95 text-gray-700 font-bold flex items-center justify-center text-xs transition-colors cursor-pointer"
                                            title="Kurangi Stok (-1)">
                                        -
                                    </button>
                                </form>
                                <span class="font-bold text-gray-900 px-1 text-xs min-w-[18px] text-center">{{ $book->stock }}</span>
                                <form method="POST" action="{{ route('books.stock', $book) }}" class="inline">
                                    @csrf
                                    <button type="submit" name="delta" value="1"
                                            class="w-6 h-6 rounded bg-emerald-100 hover:bg-emerald-200 active:scale-95 text-emerald-800 font-bold flex items-center justify-center text-xs transition-colors cursor-pointer"
                                            title="Tambah Stok (+1)">
                                        +
                                    </button>
                                </form>
                            </div>
                        @else
                            <span class="font-bold text-gray-900 text-xs">Stok: {{ $book->stock }}</span>
                        @endif
                        <span class="text-[10px] text-gray-400">/ {{ $book->total_copies }} eks</span>
                    </div>

                    <!-- Status Badge -->
                    <div>
                        @if($book->status === 'Tersedia')
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                Tersedia
                            </span>
                        @elseif($book->status === 'Stok Kritis')
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                Stok Kritis
                            </span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">
                                Habis
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Bottom Action Buttons -->
                <div class="flex items-center gap-1.5 mt-2.5 pt-2 border-t border-gray-100">
                    <button type="button" onclick="openBookDetailModal({{ $book->id }})"
                            class="flex-1 py-1.5 px-3 bg-gray-50 hover:bg-emerald-50 hover:text-emerald-800 text-gray-700 rounded-lg text-xs font-semibold border border-gray-200 flex items-center justify-center gap-1 transition-colors cursor-pointer">
                        <span class="material-symbols-outlined text-[16px]">visibility</span>
                        <span>Detail</span>
                    </button>

                    @if(auth()->check() && !auth()->user()->isLibrarian() && $book->stock > 0)
                        <form method="POST" action="{{ route('loans.store') }}" class="flex-1">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            <button type="submit" class="w-full py-1.5 px-3 bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg text-xs font-semibold flex items-center justify-center gap-1 transition-all cursor-pointer shadow-2xs">
                                <span class="material-symbols-outlined text-[16px]">assignment_add</span>
                                <span>Pinjam</span>
                            </button>
                        </form>
                    @endif

                    @if($book->is_ebook)
                        <a href="{{ route('ebooks.show', $book) }}"
                           class="py-1.5 px-2.5 rounded-lg bg-[#2373F4]/10 text-[#2373F4] hover:bg-[#2373F4]/20 text-xs font-semibold flex items-center gap-1 transition-colors"
                           title="Baca E-Book Online">
                            <span class="material-symbols-outlined text-[16px]">auto_stories</span>
                            <span class="text-[11px]">E-Book</span>
                        </a>
                    @endif

                    @if(auth()->check() && auth()->user()->isLibrarian())
                        <a href="{{ route('books.edit', $book) }}"
                           class="p-1.5 rounded-lg text-gray-600 hover:text-blue-700 hover:bg-blue-50 border border-gray-200 transition-colors"
                           title="Edit Buku">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                        </a>
                        <button type="button"
                                onclick="openDeleteModal('{{ route('books.destroy', $book) }}', '{{ addslashes($book->title) }}')"
                                class="p-1.5 rounded-lg text-gray-600 hover:text-rose-700 hover:bg-rose-50 border border-gray-200 transition-colors cursor-pointer"
                                title="Hapus Buku">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                        </button>
                    @endif
                </div>
            </div>
            @empty
            <div class="py-12 text-center text-gray-500">
                <div class="flex flex-col items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-4xl text-gray-300">menu_book</span>
                    <span class="font-semibold text-gray-700 text-sm">Tidak ada buku yang sesuai dengan pencarian atau filter.</span>
                    <a href="{{ route('books.index') }}" class="text-xs text-emerald-700 hover:underline">
                        Reset Semua Filter
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        <!-- 2. Desktop Structured Table (Visible on screens >= md) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full min-w-[850px] text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-200 text-gray-500 font-bold uppercase tracking-wider text-[11px]">
                        <th class="py-3 px-4 w-12 text-center">#</th>
                        <th class="py-3 px-4">Buku &amp; Metadata</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4">Penulis &amp; Penerbit</th>
                        <th class="py-3 px-4">Lokasi Rak</th>
                        <th class="py-3 px-4 text-center">Stok Fisik</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($books as $book)
                    <tr class="hover:bg-gray-50/60 transition-colors">
                        <td class="py-3 px-4 text-center font-mono text-gray-400">
                            {{ $loop->iteration + ($books->currentPage() - 1) * $books->perPage() }}
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $book->cover_url }}" alt="{{ $book->title }}"
                                     class="w-10 h-14 object-cover rounded-md shadow-2xs border border-gray-100 flex-shrink-0 cursor-pointer hover:opacity-90 transition-opacity"
                                     onclick="openBookDetailModal({{ $book->id }})">
                                <div class="flex flex-col">
                                    <button type="button" onclick="openBookDetailModal({{ $book->id }})"
                                            class="font-headline font-bold text-gray-900 hover:text-emerald-700 text-sm line-clamp-1 text-left cursor-pointer"
                                            title="{{ $book->title }}">
                                        {{ $book->title }}
                                    </button>
                                    @if($book->subtitle)
                                    <span class="text-[11px] text-gray-400 italic line-clamp-1 max-w-xs">{{ $book->subtitle }}</span>
                                    @endif
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[10px] text-gray-500 font-mono bg-gray-100 px-1.5 py-0.5 rounded">
                                            {{ $book->isbn }}
                                        </span>
                                        <span class="text-[10px] text-gray-400">Tahun {{ $book->year }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-semibold bg-[#eff4ff] text-[#00652c] border border-[#dee9fc]">
                                {{ $book->category }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex flex-col">
                                <span class="font-medium text-gray-900">{{ $book->author }}</span>
                                <span class="text-[11px] text-gray-400">{{ $book->publisher }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center gap-1 text-[11px] font-medium text-gray-700 bg-gray-100 px-2 py-0.5 rounded-md">
                                <span class="material-symbols-outlined text-[14px] text-gray-400">shelves</span>
                                {{ $book->shelf_location }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            @if(auth()->check() && auth()->user()->isLibrarian())
                                <div class="inline-flex items-center gap-1">
                                    <form method="POST" action="{{ route('books.stock', $book) }}" class="inline">
                                        @csrf
                                        <button type="submit" name="delta" value="-1"
                                                class="w-6 h-6 rounded bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold flex items-center justify-center transition-colors text-xs cursor-pointer"
                                                title="Kurangi Stok (-1)">
                                            -
                                        </button>
                                    </form>
                                    <span class="font-bold text-gray-900 px-1 text-sm min-w-[20px]">{{ $book->stock }}</span>
                                    <form method="POST" action="{{ route('books.stock', $book) }}" class="inline">
                                        @csrf
                                        <button type="submit" name="delta" value="1"
                                                class="w-6 h-6 rounded bg-emerald-100 hover:bg-emerald-200 text-emerald-800 font-bold flex items-center justify-center transition-colors text-xs cursor-pointer"
                                                title="Tambah Stok (+1)">
                                            +
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="font-bold text-gray-900 text-sm">{{ $book->stock }}</span>
                            @endif
                            <span class="text-[10px] text-gray-400 block mt-0.5">/ {{ $book->total_copies }} eks</span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            @if($book->status === 'Tersedia')
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                    Tersedia
                                </span>
                            @elseif($book->status === 'Stok Kritis')
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">
                                    Stok Kritis
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-100 text-rose-800">
                                    Habis
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-1.5 flex-wrap">
                                <!-- Detail Modal -->
                                <button type="button" onclick="openBookDetailModal({{ $book->id }})"
                                        class="p-1.5 rounded-lg text-gray-500 hover:text-emerald-700 hover:bg-[#eff4ff] transition-colors cursor-pointer"
                                        title="Lihat Detail">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                </button>

                                @if(auth()->check() && !auth()->user()->isLibrarian() && $book->stock > 0)
                                    <form method="POST" action="{{ route('loans.store') }}" class="inline">
                                        @csrf
                                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                                        <button type="submit" class="px-2.5 py-1 bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg text-xs font-semibold flex items-center gap-1 transition-all cursor-pointer shadow-2xs" title="Pinjam Buku Ini">
                                            <span class="material-symbols-outlined text-[15px]">assignment_add</span>
                                            <span>Pinjam</span>
                                        </button>
                                    </form>
                                @endif

                                @if($book->is_ebook)
                                    <a href="{{ route('ebooks.show', $book) }}"
                                       class="p-1.5 rounded-lg text-[#2373F4] hover:text-[#1a5ec4] hover:bg-[#2373F4]/10 transition-colors"
                                       title="Baca E-Book Online">
                                        <span class="material-symbols-outlined text-[18px]">auto_stories</span>
                                    </a>
                                @endif

                                @if(auth()->check() && auth()->user()->isLibrarian())
                                    <!-- Edit Page -->
                                    <a href="{{ route('books.edit', $book) }}"
                                       class="p-1.5 rounded-lg text-gray-500 hover:text-blue-700 hover:bg-blue-50 transition-colors"
                                       title="Edit Buku">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </a>
                                    <!-- Delete Button -->
                                    <button type="button"
                                            onclick="openDeleteModal('{{ route('books.destroy', $book) }}', '{{ addslashes($book->title) }}')"
                                            class="p-1.5 rounded-lg text-gray-500 hover:text-rose-700 hover:bg-rose-50 transition-colors cursor-pointer"
                                            title="Hapus Buku">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-4xl text-gray-300">menu_book</span>
                                <span class="font-semibold text-gray-700">Tidak ada buku yang sesuai dengan pencarian atau filter.</span>
                                <a href="{{ route('books.index') }}" class="text-xs text-emerald-700 hover:underline">
                                    Reset Semua Filter
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Grid View (Hidden by default, toggled via JS) -->
    <div id="gridViewContainer" class="hidden grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-5 mb-6">
        @foreach($books as $book)
        <div class="bg-white rounded-xl sm:rounded-2xl border border-[#e6eeff] p-2.5 sm:p-4 flex flex-col justify-between hover:shadow-md transition-shadow group">
            <div>
                <div class="relative overflow-hidden rounded-lg sm:rounded-xl aspect-[3/4] max-h-[170px] sm:max-h-none mb-2 sm:mb-3 bg-gray-100">
                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute top-1.5 right-1.5 sm:top-2 sm:right-2 flex flex-col gap-1 items-end">
                        @if($book->is_ebook)
                            <span class="px-1.5 sm:px-2 py-0.5 rounded-md text-[9px] sm:text-[10px] font-bold bg-[#2373F4] text-white shadow-xs flex items-center gap-0.5">
                                <span class="material-symbols-outlined text-[10px]">devices</span>
                                <span class="hidden sm:inline">E-Book</span>
                            </span>
                        @endif
                        @if($book->status === 'Tersedia')
                            <span class="px-1.5 sm:px-2 py-0.5 rounded-md text-[9px] sm:text-[10px] font-bold bg-emerald-600 text-white shadow-xs">Tersedia</span>
                        @elseif($book->status === 'Stok Kritis')
                            <span class="px-1.5 sm:px-2 py-0.5 rounded-md text-[9px] sm:text-[10px] font-bold bg-amber-500 text-white shadow-xs">Kritis</span>
                        @else
                            <span class="px-1.5 sm:px-2 py-0.5 rounded-md text-[9px] sm:text-[10px] font-bold bg-rose-600 text-white shadow-xs">Habis</span>
                        @endif
                    </div>
                </div>
                <span class="text-[9px] sm:text-[10px] font-bold text-emerald-700 uppercase tracking-wider block mb-0.5">{{ $book->category }}</span>
                <h3 class="font-headline font-bold text-xs sm:text-sm text-gray-900 line-clamp-1" title="{{ $book->title }}">{{ $book->title }}</h3>
                <p class="text-[11px] sm:text-xs text-gray-500 line-clamp-1 mb-1.5 sm:mb-2">{{ $book->author }} · {{ $book->year }}</p>

                <div class="flex items-center justify-between text-[10px] sm:text-xs text-gray-600 bg-gray-50 p-1.5 sm:p-2 rounded-lg border border-gray-100">
                    <span class="flex items-center gap-1 text-[10px] sm:text-[11px] truncate max-w-[80px] sm:max-w-none">
                        <span class="material-symbols-outlined text-[13px] sm:text-[14px] text-gray-400">shelves</span>
                        {{ $book->shelf_location }}
                    </span>
                    <span class="font-bold text-emerald-700 text-[10px] sm:text-xs flex-shrink-0">
                        Stok: {{ $book->stock }}
                    </span>
                </div>
            </div>

            <div class="flex items-center gap-1 sm:gap-1.5 pt-2 sm:pt-3 mt-2 sm:mt-3 border-t border-gray-100 flex-wrap">
                <button type="button" onclick="openBookDetailModal({{ $book->id }})" class="flex-1 py-1 sm:py-1.5 bg-[#eff4ff] hover:bg-emerald-700 hover:text-white text-emerald-800 text-[10px] sm:text-xs font-semibold rounded-lg transition-colors flex items-center justify-center gap-1 cursor-pointer">
                    <span class="material-symbols-outlined text-[14px] sm:text-[16px]">visibility</span>
                    <span>Detail</span>
                </button>

                @if(auth()->check() && !auth()->user()->isLibrarian() && $book->stock > 0)
                    <form method="POST" action="{{ route('loans.store') }}" class="inline">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <button type="submit" class="px-2 sm:px-2.5 py-1 sm:py-1.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg text-[10px] sm:text-xs font-semibold flex items-center gap-0.5 sm:gap-1 transition-all cursor-pointer shadow-2xs" title="Pinjam Buku Ini">
                            <span class="material-symbols-outlined text-[13px] sm:text-[15px]">assignment_add</span>
                            <span class="hidden sm:inline">Pinjam</span>
                        </button>
                    </form>
                @endif

                @if($book->is_ebook)
                    <a href="{{ route('ebooks.show', $book) }}"
                       class="p-1 sm:p-1.5 rounded-lg text-[#2373F4] hover:text-[#1a5ec4] hover:bg-[#2373F4]/10 transition-colors"
                       title="Baca E-Book Online">
                        <span class="material-symbols-outlined text-[16px] sm:text-[18px]">auto_stories</span>
                    </a>
                @endif

                @if(auth()->check() && auth()->user()->isLibrarian())
                    <a href="{{ route('books.edit', $book) }}" class="p-1 sm:p-1.5 rounded-lg text-gray-500 hover:text-gray-800 hover:bg-gray-100 transition-colors" title="Edit Buku">
                        <span class="material-symbols-outlined text-[16px] sm:text-[18px]">edit</span>
                    </a>
                    <button type="button" onclick="openDeleteModal('{{ route('books.destroy', $book) }}', '{{ addslashes($book->title) }}')" class="p-1 sm:p-1.5 rounded-lg text-gray-500 hover:text-rose-700 hover:bg-rose-50 transition-colors cursor-pointer" title="Hapus Buku">
                        <span class="material-symbols-outlined text-[16px] sm:text-[18px]">delete</span>
                    </button>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2">
        <div class="text-xs text-gray-500 text-center sm:text-left">
            Halaman <strong class="text-gray-900">{{ $books->currentPage() }}</strong> dari <strong class="text-gray-900">{{ $books->lastPage() }}</strong>
        </div>

        <div class="flex items-center gap-1 flex-wrap justify-center">
            @if ($books->onFirstPage())
                <span class="px-2.5 sm:px-3 py-1.5 rounded-lg text-xs font-medium text-gray-400 bg-gray-100 cursor-not-allowed">← Prev</span>
            @else
                <a href="{{ $books->previousPageUrl() }}" class="px-2.5 sm:px-3 py-1.5 rounded-lg text-xs font-semibold text-gray-700 bg-white hover:bg-gray-50 border border-gray-200 shadow-xs transition-colors">← Prev</a>
            @endif

            @foreach ($books->getUrlRange(max(1, $books->currentPage() - 2), min($books->lastPage(), $books->currentPage() + 2)) as $page => $url)
                @if ($page == $books->currentPage())
                    <span class="px-2.5 sm:px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-emerald-700 shadow-xs">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-2.5 sm:px-3 py-1.5 rounded-lg text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 border border-gray-200 transition-colors">{{ $page }}</a>
                @endif
            @endforeach

            @if ($books->hasMorePages())
                <a href="{{ $books->nextPageUrl() }}" class="px-2.5 sm:px-3 py-1.5 rounded-lg text-xs font-semibold text-gray-700 bg-white hover:bg-gray-50 border border-gray-200 shadow-xs transition-colors">Next →</a>
            @else
                <span class="px-2.5 sm:px-3 py-1.5 rounded-lg text-xs font-medium text-gray-400 bg-gray-100 cursor-not-allowed">Next →</span>
            @endif
        </div>
    </div>
</div>

<script>
    function setViewMode(mode) {
        const tableContainer = document.getElementById('tableViewContainer');
        const gridContainer = document.getElementById('gridViewContainer');
        const tableBtn = document.getElementById('viewModeTableBtn');
        const gridBtn = document.getElementById('viewModeGridBtn');

        if (mode === 'grid') {
            tableContainer.classList.add('hidden');
            gridContainer.classList.remove('hidden');
            gridBtn.className = "px-2 py-1 rounded text-xs font-semibold flex items-center gap-1 bg-white text-emerald-800 shadow-xs";
            tableBtn.className = "px-2 py-1 rounded text-xs font-semibold flex items-center gap-1 text-gray-500 hover:text-gray-900";
        } else {
            tableContainer.classList.remove('hidden');
            gridContainer.classList.add('hidden');
            tableBtn.className = "px-2 py-1 rounded text-xs font-semibold flex items-center gap-1 bg-white text-emerald-800 shadow-xs";
            gridBtn.className = "px-2 py-1 rounded text-xs font-semibold flex items-center gap-1 text-gray-500 hover:text-gray-900";
        }
    }
</script>
@endsection
