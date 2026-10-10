<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Athenaeum Library System - Laravel & Eloquent Catalog')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600&family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Material Symbols -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#15803d',
                        'primary-dark': '#00652c',
                        'primary-light': '#eff4ff',
                        'primary-border': '#dee9fc',
                        surface: '#f8f9ff',
                        'surface-card': '#ffffff',
                        'text-main': '#121c2a',
                        'text-muted': '#6f7a6e',
                        border: '#e6eeff',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        headline: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                        mono: ['Fira Code', 'monospace'],
                    }
                }
            }
        }
    </script>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Sidebar collapse & drawer transitions */
        #appSidebar {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        #mainWrapper, #appHeader {
            transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1), left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Desktop Collapse Behavior */
        @media (min-width: 1024px) {
            body.sidebar-collapsed #appSidebar {
                transform: translateX(-100%);
            }
            body.sidebar-collapsed #mainWrapper {
                padding-left: 0 !important;
            }
            body.sidebar-collapsed #appHeader {
                left: 0 !important;
            }
        }

        /* Mobile Drawer Behavior */
        @media (max-width: 1023px) {
            #appSidebar {
                transform: translateX(-100%);
            }
            body.sidebar-mobile-open #appSidebar {
                transform: translateX(0);
            }
            #mainWrapper {
                padding-left: 0 !important;
            }
            #appHeader {
                left: 0 !important;
            }
        }
    </style>
    <script>
        // Check saved sidebar preference before paint
        if (window.innerWidth >= 1024 && localStorage.getItem('athenaeum_sidebar_collapsed') === 'true') {
            document.documentElement.classList.add('sidebar-collapsed-pending');
        }
    </script>
</head>
<body class="bg-[#f8f9ff] text-[#121c2a] font-sans antialiased min-h-screen">
    <!-- Mobile Backdrop -->
    <div id="sidebarBackdrop" onclick="toggleSidebar(false)"
         class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-40 lg:hidden hidden transition-opacity duration-300"></div>

    <div class="min-h-screen flex">
        <!-- Sidebar Navigation -->
        <aside id="appSidebar" class="fixed left-0 top-0 h-screen w-64 bg-white flex flex-col justify-between z-50 shadow-[0_4px_20px_rgba(0,0,0,0.05)] border-r border-[#e6eeff]">
            <div class="flex flex-col">
                <!-- Brand Header -->
                <div class="h-16 px-4 flex items-center justify-between border-b border-[#f1f5f9]">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#15803d] to-[#00652c] flex items-center justify-center text-white shadow-sm group-hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined text-[20px]">local_library</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-headline font-bold text-base text-[#121c2a] tracking-tight leading-none">
                                Athenaeum
                            </span>
                            <span class="text-[10px] uppercase text-[#00652c] font-bold tracking-wider mt-0.5">
                                Library System
                            </span>
                        </div>
                    </a>

                    <!-- Sidebar Hide / Collapse Button -->
                    <button type="button" onclick="toggleSidebar()"
                            title="Sembunyikan Sidebar (Ctrl+B)"
                            class="w-8 h-8 rounded-lg text-[#6f7a6e] hover:text-[#121c2a] hover:bg-[#eff4ff] flex items-center justify-center transition-colors">
                        <span class="material-symbols-outlined text-[20px]">keyboard_double_arrow_left</span>
                    </button>
                </div>

                <!-- Navigation Section Title -->
                <div class="px-4 pt-4 pb-2">
                    <span class="text-[11px] font-bold text-[#6f7a6e] uppercase tracking-wider px-1">
                        Navigasi Katalog
                    </span>
                </div>

                <!-- Nav Items -->
                <nav class="flex flex-col gap-1 px-3">
                    <!-- 1. Dashboard -->
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all text-sm {{ request()->routeIs('dashboard') ? 'bg-[#15803d] text-white font-semibold shadow-sm' : 'text-[#3f493f] hover:bg-[#eff4ff] hover:text-[#121c2a]' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('dashboard') ? 'text-white' : 'text-[#6f7a6e]' }}">dashboard</span>
                            <span>Dashboard</span>
                        </div>
                    </a>

                    <!-- 2. Manajemen Buku -->
                    <a href="{{ route('books.index') }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all text-sm {{ request()->routeIs('books.*') ? 'bg-[#15803d] text-white font-semibold shadow-sm' : 'text-[#3f493f] hover:bg-[#eff4ff] hover:text-[#121c2a]' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('books.*') ? 'text-white' : 'text-[#6f7a6e]' }}">menu_book</span>
                            <span>Manajemen Buku</span>
                        </div>
                        <span class="px-1.5 py-0.5 text-[10px] rounded-full font-bold {{ request()->routeIs('books.*') ? 'bg-white/20 text-white' : 'bg-[#eff4ff] text-[#6f7a6e]' }}">
                            {{ \App\Models\Book::count() }}
                        </span>
                    </a>

                    <!-- 3. Kategori -->
                    <a href="{{ route('categories.index') }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all text-sm {{ request()->routeIs('categories.*') ? 'bg-[#15803d] text-white font-semibold shadow-sm' : 'text-[#3f493f] hover:bg-[#eff4ff] hover:text-[#121c2a]' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('categories.*') ? 'text-white' : 'text-[#6f7a6e]' }}">category</span>
                            <span>Kategori DDC</span>
                        </div>
                        <span class="px-1.5 py-0.5 text-[10px] rounded-full font-bold {{ request()->routeIs('categories.*') ? 'bg-white/20 text-white' : 'bg-[#eff4ff] text-[#6f7a6e]' }}">
                            {{ \App\Models\Category::count() }}
                        </span>
                    </a>

                    <!-- 4. Laporan Inventaris -->
                    <a href="{{ route('inventory.index') }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all text-sm {{ request()->routeIs('inventory.*') ? 'bg-[#15803d] text-white font-semibold shadow-sm' : 'text-[#3f493f] hover:bg-[#eff4ff] hover:text-[#121c2a]' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('inventory.*') ? 'text-white' : 'text-[#6f7a6e]' }}">inventory_2</span>
                            <span>Audit &amp; Rak Fisik</span>
                        </div>
                    </a>

                    <!-- 5. Laravel & Eloquent Studio -->
                    <a href="{{ route('laravel-studio.index') }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all text-sm {{ request()->routeIs('laravel-studio.*') ? 'bg-[#15803d] text-white font-semibold shadow-sm' : 'text-[#3f493f] hover:bg-[#eff4ff] hover:text-[#121c2a]' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('laravel-studio.*') ? 'text-white' : 'text-[#6f7a6e]' }}">code_blocks</span>
                            <span>Laravel &amp; Eloquent</span>
                        </div>
                        <span class="px-1.5 py-0.5 text-[10px] rounded-full font-bold bg-[#d3ffd5] text-[#00652c]">
                            Blade
                        </span>
                    </a>

                    <!-- 6. Pengaturan -->
                    <a href="{{ route('settings.index') }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all text-sm {{ request()->routeIs('settings.*') ? 'bg-[#15803d] text-white font-semibold shadow-sm' : 'text-[#3f493f] hover:bg-[#eff4ff] hover:text-[#121c2a]' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('settings.*') ? 'text-white' : 'text-[#6f7a6e]' }}">settings</span>
                            <span>Pengaturan</span>
                        </div>
                    </a>
                </nav>
            </div>

            <!-- System Info Footer Card -->
            <div class="p-3 m-3 bg-[#eff4ff] rounded-xl border border-[#dee9fc]">
                <div class="flex items-center justify-between mb-1">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-[#15803d] animate-pulse"></span>
                        <span class="text-[11px] font-bold text-[#1f6c3a] uppercase tracking-wider">
                            Laravel {{ app()->version() }}
                        </span>
                    </div>
                    <span class="text-[11px] text-[#6f7a6e] font-mono">PHP {{ PHP_MAJOR_VERSION }}.{{ PHP_MINOR_VERSION }}</span>
                </div>
                <div class="text-xs text-[#3f493f] font-medium">Eloquent ORM Engine</div>
                <div class="mt-2 pt-2 border-t border-[#dee9fc] flex items-center justify-between text-[10px] text-[#6f7a6e]">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-[13px] text-[#00652c]">database</span>
                        {{ config('database.default') }}
                    </span>
                    <span class="text-[#00652c] font-semibold">Terkoneksi</span>
                </div>
            </div>
        </aside>

        <!-- Main Wrapper -->
        <div id="mainWrapper" class="lg:pl-64 pl-0 flex flex-col flex-1 min-h-screen">
            <!-- Sticky Top Header -->
            <header id="appHeader" class="fixed top-0 lg:left-64 left-0 right-0 h-16 bg-white/95 backdrop-blur-xl z-40 border-b border-[#e6eeff] px-4 sm:px-8 flex items-center justify-between shadow-[0_1px_8px_rgba(0,0,0,0.03)]">
                <div class="flex items-center gap-3">
                    <!-- Toggle Sidebar Button (Show / Hide) -->
                    <button id="sidebarToggleBtn" type="button" onclick="toggleSidebar()"
                            title="Tampilkan / Sembunyikan Sidebar (Ctrl+B)"
                            aria-label="Toggle Sidebar"
                            class="p-2 rounded-xl text-[#3f493f] hover:text-[#121c2a] hover:bg-[#eff4ff] border border-[#e6eeff] transition-all flex items-center justify-center">
                        <span id="sidebarToggleIcon" class="material-symbols-outlined text-[20px]">menu_open</span>
                    </button>

                    <div class="flex items-center gap-1.5 text-[#3f493f] text-sm">
                        <span class="font-semibold text-[#121c2a] hidden sm:inline">Athenaeum</span>
                        <span class="material-symbols-outlined text-[16px] text-[#6f7a6e] hidden sm:inline">chevron_right</span>
                        <span class="text-[#6f7a6e] font-medium text-xs sm:text-sm">@yield('page_category', 'Katalog Perpustakaan')</span>
                    </div>
                    <div class="h-4 w-px bg-[#d9e3f6] hidden md:block"></div>
                    <div class="hidden md:flex items-center gap-1.5 text-[#6f7a6e] text-xs font-medium">
                        <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                        <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-2 sm:gap-3">
                    <!-- Blade App UI vs Laravel Studio Toggle -->
                    <div class="hidden xl:flex items-center bg-[#eff4ff] p-1 rounded-xl border border-[#dee9fc]">
                        <a href="{{ route('books.index') }}"
                           class="px-3 py-1 rounded-lg text-xs font-semibold flex items-center gap-1.5 transition-all {{ !request()->routeIs('laravel-studio.*') ? 'bg-white text-[#00652c] shadow-sm' : 'text-[#6f7a6e] hover:text-[#121c2a]' }}">
                            <span class="material-symbols-outlined text-[16px]">web</span>
                            <span>Blade App UI</span>
                        </a>
                        <a href="{{ route('laravel-studio.index') }}"
                           class="px-3 py-1 rounded-lg text-xs font-semibold flex items-center gap-1.5 transition-all {{ request()->routeIs('laravel-studio.*') ? 'bg-[#15803d] text-white shadow-sm' : 'text-[#6f7a6e] hover:text-[#121c2a]' }}">
                            <span class="material-symbols-outlined text-[16px]">code</span>
                            <span>Laravel Eloquent Source</span>
                        </a>
                    </div>

                    <!-- Global Search trigger button -->
                    <button type="button" onclick="openGlobalSearch()"
                            class="flex items-center gap-2 px-3 py-1.5 bg-[#eff4ff] hover:bg-[#e6eeff] rounded-xl text-[#6f7a6e] hover:text-[#121c2a] transition-colors border border-[#dee9fc]">
                        <span class="material-symbols-outlined text-[18px]">search</span>
                        <span class="text-xs hidden lg:inline">Cari judul, ISBN, rak...</span>
                        <kbd class="hidden sm:inline-block px-1.5 py-0.5 text-[10px] font-bold bg-white text-[#121c2a] rounded shadow-xs">
                            ⌘K
                        </kbd>
                    </button>

                    <!-- MySQL .sql Dump Export -->
                    <a href="{{ route('books.export.sql') }}"
                       title="Download MySQL Dump (.sql)"
                       class="flex items-center gap-1 px-2.5 py-1.5 bg-[#eff4ff] hover:bg-[#d9e3f6] text-[#00652c] rounded-xl text-xs font-semibold transition-colors border border-[#dee9fc]">
                        <span class="material-symbols-outlined text-[18px]">database</span>
                        <span class="hidden sm:inline">MySQL .sql</span>
                    </a>

                    <!-- CSV Export -->
                    <a href="{{ route('books.export.csv') }}"
                       title="Download Data Katalog (CSV)"
                       class="flex items-center gap-1 px-2.5 py-1.5 bg-[#eff4ff] hover:bg-[#d9e3f6] text-[#00652c] rounded-xl text-xs font-semibold transition-colors border border-[#dee9fc]">
                        <span class="material-symbols-outlined text-[18px]">file_download</span>
                        <span class="hidden sm:inline">CSV</span>
                    </a>

                    <div class="h-6 w-px bg-[#d9e3f6]"></div>

                    <!-- User profile badge -->
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#15803d] to-[#00652c] text-white flex items-center justify-center font-bold text-xs shadow-sm">
                            DP
                        </div>
                        <div class="hidden sm:flex flex-col text-left">
                            <span class="text-xs font-semibold text-[#121c2a] leading-tight">Dimas Prakoso</span>
                            <span class="text-[11px] text-[#6f7a6e] leading-tight">Head Librarian</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Canvas -->
            <main class="w-full pt-20 px-8 pb-12 bg-[#f8f9ff] flex-1">
                <!-- Flash Success Notification Toast -->
                @if(session('success'))
                <div id="toast-success" class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center justify-between shadow-xs transition-all animate-in fade-in">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-[20px]">check_circle</span>
                        </div>
                        <div>
                            <span class="font-bold text-sm block">Berhasil:</span>
                            <span class="text-xs text-emerald-700">{{ session('success') }}</span>
                        </div>
                    </div>
                    <button onclick="document.getElementById('toast-success').remove()" type="button" class="text-emerald-600 hover:text-emerald-900 p-1">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>
                @endif

                <!-- Flash Error Notification Toast -->
                @if(session('error') || $errors->any())
                <div id="toast-error" class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl flex items-center justify-between shadow-xs transition-all animate-in fade-in">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-red-600 text-white flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-[20px]">error</span>
                        </div>
                        <div>
                            <span class="font-bold text-sm block">Terjadi Kesalahan:</span>
                            <ul class="text-xs text-red-700 list-disc list-inside">
                                @if(session('error'))
                                    <li>{{ session('error') }}</li>
                                @endif
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button onclick="document.getElementById('toast-error').remove()" type="button" class="text-red-600 hover:text-red-900 p-1">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>
                @endif

                <!-- Page Injected Content -->
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Global Delete Confirmation Modal -->
    <div id="globalDeleteModal" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-gray-100 flex flex-col gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-[26px]">delete_forever</span>
                </div>
                <div>
                    <h3 class="font-headline font-bold text-lg text-gray-900">Konfirmasi Hapus Buku</h3>
                    <p class="text-xs text-gray-500">Tindakan ini permanen dan akan menghapus data buku dari database katalog.</p>
                </div>
            </div>

            <div class="bg-gray-50 p-3 rounded-xl border border-gray-200 text-xs text-gray-700">
                Apakah Anda yakin ingin menghapus buku <strong id="deleteBookTitle"></strong>?
            </div>

            <form id="globalDeleteForm" method="POST" action="" class="flex items-center justify-end gap-2 pt-2">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 rounded-xl text-xs font-semibold text-gray-600 hover:bg-gray-100 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-xl text-xs font-semibold bg-red-600 hover:bg-red-700 text-white shadow-sm transition-colors flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">delete</span>
                    <span>Hapus Sekarang</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Global Detail Modal (AJAX Loaded) -->
    <div id="globalDetailModal" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-2xl w-full p-6 shadow-xl border border-gray-100 flex flex-col max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-700 text-[22px]">book_2</span>
                    <h3 class="font-headline font-bold text-lg text-gray-900">Detail Eksemplar Koleksi</h3>
                </div>
                <button type="button" onclick="closeDetailModal()" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-gray-700 hover:bg-gray-100">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>

            <div id="detailModalBody" class="flex flex-col gap-4">
                <div class="flex items-center justify-center py-12 text-gray-400">
                    <span class="material-symbols-outlined text-3xl animate-spin">sync</span>
                    <span class="ml-2 text-sm">Memuat informasi buku dari database...</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Global Search Modal (Ctrl+K) -->
    <div id="globalSearchModal" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-xs flex items-start justify-center pt-20 p-4">
        <div class="bg-white rounded-2xl max-w-xl w-full shadow-2xl border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex items-center gap-3">
                <span class="material-symbols-outlined text-gray-400 text-[22px]">search</span>
                <input type="text" id="globalSearchInput" placeholder="Cari judul, ISBN, penulis, atau rak... (tekan ESC untuk menutup)"
                       class="w-full text-sm outline-none bg-transparent text-gray-900 placeholder:text-gray-400"
                       onkeyup="if(event.key === 'Enter') executeGlobalSearch()">
                <button type="button" onclick="closeGlobalSearch()" class="text-gray-400 hover:text-gray-600 text-xs px-2 py-1 rounded bg-gray-100">
                    ESC
                </button>
            </div>
            <div class="p-3 bg-gray-50 text-[11px] text-gray-500 flex items-center justify-between">
                <span>Tekan <strong class="text-gray-700">Enter</strong> untuk langsung menuju halaman hasil katalog.</span>
                <button type="button" onclick="executeGlobalSearch()" class="text-emerald-700 font-semibold hover:underline">
                    Cari di Katalog →
                </button>
            </div>
        </div>
    </div>

    <!-- Global JavaScript Helper Functions -->
    <script>
        // Sidebar Toggle & Persistence Logic
        function initSidebarState() {
            const isDesktop = window.innerWidth >= 1024;
            const savedCollapsed = localStorage.getItem('athenaeum_sidebar_collapsed') === 'true';
            const toggleIcon = document.getElementById('sidebarToggleIcon');

            if (isDesktop && savedCollapsed) {
                document.body.classList.add('sidebar-collapsed');
                if (toggleIcon) toggleIcon.textContent = 'menu';
            } else if (isDesktop) {
                document.body.classList.remove('sidebar-collapsed');
                if (toggleIcon) toggleIcon.textContent = 'menu_open';
            } else {
                // On mobile, start closed
                document.body.classList.remove('sidebar-mobile-open');
                if (toggleIcon) toggleIcon.textContent = 'menu';
            }
        }

        function toggleSidebar(forceState) {
            const isDesktop = window.innerWidth >= 1024;
            const toggleIcon = document.getElementById('sidebarToggleIcon');
            const backdrop = document.getElementById('sidebarBackdrop');

            if (isDesktop) {
                // Desktop collapse / pull out
                const isCurrentlyCollapsed = document.body.classList.contains('sidebar-collapsed');
                const willCollapse = forceState !== undefined ? forceState : !isCurrentlyCollapsed;

                if (willCollapse) {
                    document.body.classList.add('sidebar-collapsed');
                    localStorage.setItem('athenaeum_sidebar_collapsed', 'true');
                    if (toggleIcon) toggleIcon.textContent = 'menu';
                } else {
                    document.body.classList.remove('sidebar-collapsed');
                    localStorage.setItem('athenaeum_sidebar_collapsed', 'false');
                    if (toggleIcon) toggleIcon.textContent = 'menu_open';
                }
            } else {
                // Mobile slide drawer
                const isOpen = document.body.classList.contains('sidebar-mobile-open');
                const willOpen = forceState !== undefined ? forceState : !isOpen;

                if (willOpen) {
                    document.body.classList.add('sidebar-mobile-open');
                    if (backdrop) backdrop.classList.remove('hidden');
                    if (toggleIcon) toggleIcon.textContent = 'close';
                } else {
                    document.body.classList.remove('sidebar-mobile-open');
                    if (backdrop) backdrop.classList.add('hidden');
                    if (toggleIcon) toggleIcon.textContent = 'menu';
                }
            }
        }

        // Initialize state on page load and window resize
        document.addEventListener('DOMContentLoaded', initSidebarState);
        window.addEventListener('resize', function() {
            const isDesktop = window.innerWidth >= 1024;
            const backdrop = document.getElementById('sidebarBackdrop');
            if (isDesktop && backdrop) {
                backdrop.classList.add('hidden');
                document.body.classList.remove('sidebar-mobile-open');
                initSidebarState();
            }
        });

        // Keyboard Shortcut ⌘K / Ctrl+K and ⌘B / Ctrl+B
        document.addEventListener('keydown', function(e) {
            if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
                e.preventDefault();
                openGlobalSearch();
            }
            if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'b') {
                e.preventDefault();
                toggleSidebar();
            }
            if (e.key === 'Escape') {
                closeGlobalSearch();
                closeDeleteModal();
                closeDetailModal();
                if (window.innerWidth < 1024) {
                    toggleSidebar(false);
                }
            }
        });

        function openGlobalSearch() {
            const modal = document.getElementById('globalSearchModal');
            modal.classList.remove('hidden');
            setTimeout(() => document.getElementById('globalSearchInput').focus(), 100);
        }

        function closeGlobalSearch() {
            document.getElementById('globalSearchModal').classList.add('hidden');
        }

        function executeGlobalSearch() {
            const term = document.getElementById('globalSearchInput').value.trim();
            if (term) {
                window.location.href = "{{ route('books.index') }}?search=" + encodeURIComponent(term);
            }
        }

        function openDeleteModal(actionUrl, bookTitle) {
            document.getElementById('globalDeleteForm').action = actionUrl;
            document.getElementById('deleteBookTitle').textContent = `"${bookTitle}"`;
            document.getElementById('globalDeleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('globalDeleteModal').classList.add('hidden');
        }

        function openBookDetailModal(bookId) {
            const modal = document.getElementById('globalDetailModal');
            const body = document.getElementById('detailModalBody');
            modal.classList.remove('hidden');
            body.innerHTML = `
                <div class="flex items-center justify-center py-12 text-gray-400">
                    <span class="material-symbols-outlined text-3xl animate-spin">sync</span>
                    <span class="ml-2 text-sm">Memuat informasi buku...</span>
                </div>
            `;

            fetch(`/books/${bookId}`, {
                headers: { 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                const book = data.book;
                const coverUrl = data.cover_url || book.cover_image;
                const statusBadge = book.status === 'Tersedia'
                    ? '<span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">Tersedia</span>'
                    : (book.status === 'Stok Kritis'
                        ? '<span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">Stok Kritis</span>'
                        : '<span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-800">Habis</span>');

                body.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="flex flex-col items-center">
                            <img src="${coverUrl}" alt="${book.title}" class="w-full max-w-[200px] h-64 object-cover rounded-xl shadow-md border border-gray-100">
                            <div class="mt-3 text-center">
                                <span class="text-[11px] text-gray-500 font-mono block">${book.isbn}</span>
                                <div class="mt-1">${statusBadge}</div>
                            </div>
                        </div>
                        <div class="md:col-span-2 flex flex-col justify-between">
                            <div>
                                <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider">${book.category}</span>
                                <h2 class="font-headline font-bold text-xl text-gray-900 mt-1">${book.title}</h2>
                                ${book.subtitle ? `<p class="text-xs text-gray-500 italic mt-0.5">${book.subtitle}</p>` : ''}
                                
                                <div class="grid grid-cols-2 gap-3 mt-4 text-xs">
                                    <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-100">
                                        <span class="text-gray-400 block text-[10px] uppercase font-bold">Penulis</span>
                                        <strong class="text-gray-800">${book.author}</strong>
                                    </div>
                                    <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-100">
                                        <span class="text-gray-400 block text-[10px] uppercase font-bold">Penerbit</span>
                                        <strong class="text-gray-800">${book.publisher} (${book.year})</strong>
                                    </div>
                                    <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-100">
                                        <span class="text-gray-400 block text-[10px] uppercase font-bold">Lokasi Rak</span>
                                        <strong class="text-gray-800">${book.shelf_location}</strong>
                                    </div>
                                    <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-100">
                                        <span class="text-gray-400 block text-[10px] uppercase font-bold">Stok Fisik</span>
                                        <strong class="text-emerald-700 text-sm">${book.stock}</strong> <span class="text-gray-500">/ ${book.total_copies} eksemplar</span>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <span class="text-xs font-bold text-gray-700 block mb-1">Sinopsis & Ringkasan:</span>
                                    <p class="text-xs text-gray-600 leading-relaxed bg-white p-3 rounded-lg border border-gray-100">
                                        ${book.description || 'Tidak ada deskripsi rinci untuk buku ini.'}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between gap-3 pt-4 border-t border-gray-100 mt-4">
                                <form method="POST" action="/books/${book.id}/stock" class="flex items-center gap-1.5">
                                    <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                                    <span class="text-xs font-medium text-gray-500 mr-1">Penyesuaian Stok:</span>
                                    <button type="submit" name="delta" value="-1" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold flex items-center justify-center transition-colors">
                                        -
                                    </button>
                                    <span class="px-2 text-xs font-bold text-gray-800">${book.stock}</span>
                                    <button type="submit" name="delta" value="1" class="w-8 h-8 rounded-lg bg-emerald-100 hover:bg-emerald-200 text-emerald-800 font-bold flex items-center justify-center transition-colors">
                                        +
                                    </button>
                                </form>

                                <div class="flex items-center gap-2">
                                    <a href="/books/${book.id}/edit" class="px-3 py-1.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold flex items-center gap-1 transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">edit</span>
                                        <span>Edit Data</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            })
            .catch(err => {
                body.innerHTML = `
                    <div class="p-4 bg-red-50 text-red-700 rounded-xl text-xs">
                        Gagal memuat data buku: ${err.message}
                    </div>
                `;
            });
        }

        function closeDetailModal() {
            document.getElementById('globalDetailModal').classList.add('hidden');
        }
    </script>
</body>
</html>
