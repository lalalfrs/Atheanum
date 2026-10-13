<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Book Library - Digital Catalog')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">

    <!-- Material Symbols -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: '#F5F0E8',
                        'cream-dark': '#EDE7DB',
                        'cream-light': '#FAF7F2',
                        forest: '#1B3A2D',
                        'forest-light': '#2A5440',
                        coral: '#E8734A',
                        'coral-light': '#F4A27A',
                        'surface-grey': '#F0EEEB',
                        'text-primary': '#1A1A1A',
                        'text-secondary': '#6B6B6B',
                        'text-muted': '#9B9B9B',
                        'border-light': '#E8E5E0',
                    },
                    fontFamily: {
                        sans: ['DM Sans', 'system-ui', 'sans-serif'],
                        headline: ['DM Sans', 'system-ui', 'sans-serif'],
                    },
                    borderRadius: {
                        '2xl': '16px',
                        '3xl': '24px',
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
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d4d0ca; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #b0aba3; }

        /* Sidebar transitions */
        #appSidebar {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        #mainWrapper {
            transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Desktop Collapse */
        @media (min-width: 1024px) {
            body.sidebar-collapsed #appSidebar {
                transform: translateX(-100%);
            }
            body.sidebar-collapsed #mainWrapper {
                padding-left: 0 !important;
            }
        }

        /* Mobile Drawer */
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
        }

        /* Decorative curve for cream area */
        .cream-curve {
            position: relative;
        }
        .cream-curve::after {
            content: '';
            position: absolute;
            bottom: -40px;
            left: 0;
            right: 0;
            height: 40px;
            background: #F5F0E8;
            border-radius: 0 0 50% 50% / 0 0 100% 100%;
        }
    </style>
    <script>
        if (window.innerWidth >= 1024 && localStorage.getItem('bl_sidebar_collapsed') === 'true') {
            document.documentElement.classList.add('sidebar-collapsed-pending');
        }
    </script>
</head>
<body class="bg-cream-light text-text-primary font-sans antialiased min-h-screen">
    <!-- Mobile Backdrop -->
    <div id="sidebarBackdrop" onclick="toggleSidebar(false)"
         class="fixed inset-0 bg-black/30 z-40 lg:hidden hidden transition-opacity duration-300"></div>

    <div class="min-h-screen flex">
        <!-- Sidebar Navigation -->
        <aside id="appSidebar" class="fixed left-0 top-0 h-screen w-[260px] bg-white flex flex-col justify-between z-50 border-r border-border-light">
            <div class="flex flex-col flex-1 overflow-y-auto">
                <!-- Menu Label -->
                <div class="px-6 pt-7 pb-3">
                    <span class="text-[11px] font-bold text-text-muted uppercase tracking-[0.15em]">Menu</span>
                </div>

                <!-- Nav Items -->
                <nav class="flex flex-col gap-0.5 px-4">
                    <!-- Beranda Utama -->
                    <a href="{{ route('home') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-[14px] font-medium text-text-secondary hover:bg-surface-grey hover:text-text-primary">
                        <span class="material-symbols-outlined text-[22px] text-[#2373F4]">home</span>
                        <span>Beranda Utama</span>
                    </a>

                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-[14px] font-medium {{ request()->routeIs('dashboard') ? 'text-coral font-semibold' : 'text-text-secondary hover:bg-surface-grey hover:text-text-primary' }}">
                        <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('dashboard') ? 'text-coral' : 'text-text-muted' }}">space_dashboard</span>
                        <span>Dashboard</span>
                    </a>

                    <!-- Katalog Buku -->
                    <a href="{{ route('books.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-[14px] font-medium {{ request()->routeIs('books.*') ? 'text-coral font-semibold' : 'text-text-secondary hover:bg-surface-grey hover:text-text-primary' }}">
                        <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('books.*') ? 'text-coral' : 'text-text-muted' }}">menu_book</span>
                        <span>{{ auth()->check() && auth()->user()->isLibrarian() ? 'Manajemen Buku' : 'Katalog Buku' }}</span>
                    </a>

                    <!-- E-Book Digital -->
                    <a href="{{ route('ebooks.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-[14px] font-medium {{ request()->routeIs('ebooks.*') ? 'text-coral font-semibold' : 'text-text-secondary hover:bg-surface-grey hover:text-text-primary' }}">
                        <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('ebooks.*') ? 'text-coral' : 'text-text-muted' }}">auto_stories</span>
                        <span>E-Book Digital</span>
                    </a>

                    @auth
                    <!-- Peminjaman -->
                    <a href="{{ route('loans.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-[14px] font-medium {{ request()->routeIs('loans.*') ? 'text-coral font-semibold' : 'text-text-secondary hover:bg-surface-grey hover:text-text-primary' }}">
                        <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('loans.*') ? 'text-coral' : 'text-text-muted' }}">assignment</span>
                        <span>{{ auth()->user()->isLibrarian() ? 'Sirkulasi Pinjaman' : 'Peminjaman Saya' }}</span>
                    </a>
                    @endauth

                    <!-- Separator -->
                    <div class="my-2 border-t border-border-light"></div>

                    <!-- Kategori DDC -->
                    <a href="{{ route('categories.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-[14px] font-medium {{ request()->routeIs('categories.*') ? 'text-coral font-semibold' : 'text-text-secondary hover:bg-surface-grey hover:text-text-primary' }}">
                        <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('categories.*') ? 'text-coral' : 'text-text-muted' }}">category</span>
                        <span>Kategori DDC</span>
                    </a>

                    @if(auth()->check() && auth()->user()->isLibrarian())
                    <!-- Audit & Rak Fisik -->
                    <a href="{{ route('inventory.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-[14px] font-medium {{ request()->routeIs('inventory.*') ? 'text-coral font-semibold' : 'text-text-secondary hover:bg-surface-grey hover:text-text-primary' }}">
                        <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('inventory.*') ? 'text-coral' : 'text-text-muted' }}">inventory_2</span>
                        <span>Audit &amp; Rak Fisik</span>
                    </a>


                    <!-- Separator -->
                    <div class="my-2 border-t border-border-light"></div>

                    <!-- Pengaturan -->
                    <a href="{{ route('settings.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-[14px] font-medium {{ request()->routeIs('settings.*') ? 'text-coral font-semibold' : 'text-text-secondary hover:bg-surface-grey hover:text-text-primary' }}">
                        <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('settings.*') ? 'text-coral' : 'text-text-muted' }}">settings</span>
                        <span>Pengaturan</span>
                    </a>
                    @endif

                    @if(auth()->check() && auth()->user()->isSuperAdmin())
                    <!-- Manajemen Pengguna -->
                    <a href="{{ route('users.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-[14px] font-medium {{ request()->routeIs('users.*') ? 'text-coral font-semibold' : 'text-text-secondary hover:bg-surface-grey hover:text-text-primary' }}">
                        <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('users.*') ? 'text-coral' : 'text-text-muted' }}">manage_accounts</span>
                        <span>Manajemen User</span>
                    </a>
                    @endif

                    @guest
                    <!-- Login -->
                    <a href="{{ route('login') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-[14px] font-medium {{ request()->routeIs('login') ? 'text-coral font-semibold' : 'text-text-secondary hover:bg-surface-grey hover:text-text-primary' }}">
                        <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('login') ? 'text-coral' : 'text-text-muted' }}">login</span>
                        <span>Masuk Sistem</span>
                    </a>

                    <!-- Register -->
                    <a href="{{ route('register') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-[14px] font-medium {{ request()->routeIs('register') ? 'text-coral font-semibold' : 'text-text-secondary hover:bg-surface-grey hover:text-text-primary' }}">
                        <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('register') ? 'text-coral' : 'text-text-muted' }}">person_add</span>
                        <span>Daftar Akun Baru</span>
                    </a>
                    @else
                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="w-full mt-1 pt-2 border-t border-border-light">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-[14px] font-medium text-red-500 hover:bg-red-50 text-left cursor-pointer">
                            <span class="material-symbols-outlined text-[22px] text-red-400">logout</span>
                            <span>Keluar Sistem</span>
                        </button>
                    </form>
                    @endguest
                </nav>
            </div>

            <!-- Logo at bottom of sidebar -->
            <div class="p-6 flex flex-col items-center gap-2">
                <!-- Abstract logo shape -->
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-[#2373F4] to-[#1a5ec4] flex items-center justify-center shadow-sm">
                    <span class="material-symbols-outlined text-white text-[20px]">local_library</span>
                </div>
                <span class="text-[11px] font-bold text-text-secondary uppercase tracking-[0.2em]">Book Library</span>
            </div>
        </aside>

        <!-- Main Wrapper -->
        <div id="mainWrapper" class="lg:pl-[260px] pl-0 flex flex-col flex-1 min-h-screen">
            <!-- Main Content -->
            <main class="w-full flex-1">
                <!-- Cream Top Area with decorative curve -->
                <div class="bg-cream pt-4 sm:pt-6 pb-10 sm:pb-14 px-4 sm:px-10 relative z-30">
                    <!-- Decorative curve bottom -->
                    <div class="absolute bottom-0 left-0 right-0 h-[30px] sm:h-[40px] overflow-hidden">
                        <div class="w-full h-[60px] sm:h-[80px] bg-cream-light rounded-t-[50%]"></div>
                    </div>

                    <!-- Top Bar: Page title + User profile -->
                    <div class="flex items-center justify-between relative z-10">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <!-- Mobile sidebar toggle -->
                            <button type="button" onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl text-text-secondary hover:bg-cream-dark transition-colors cursor-pointer" aria-label="Toggle Sidebar">
                                <span class="material-symbols-outlined text-[22px]">menu</span>
                            </button>
                            <div class="lg:hidden flex items-center gap-2">
                                <div class="w-8 h-8 rounded-xl bg-forest text-white flex items-center justify-center font-bold text-xs shadow-xs">
                                    <span class="material-symbols-outlined text-[18px]">local_library</span>
                                </div>
                                <span class="font-bold text-sm text-text-primary tracking-tight">Athenaeum</span>
                            </div>
                            <!-- Desktop sidebar toggle -->
                            <button id="sidebarToggleBtn" type="button" onclick="toggleSidebar()"
                                    title="Tampilkan / Sembunyikan Sidebar (Ctrl+B)"
                                    aria-label="Toggle Sidebar"
                                    class="hidden lg:flex p-2 rounded-xl text-text-secondary hover:bg-cream-dark transition-colors items-center justify-center cursor-pointer">
                                <span id="sidebarToggleIcon" class="material-symbols-outlined text-[22px]">menu_open</span>
                            </button>
                        </div>

                        <!-- User Profile -->
                        <div class="flex items-center gap-2 sm:gap-3">
                            @auth
                            <div class="relative group" id="userProfileDropdown">
                                <button type="button" id="profileDropdownBtn" onclick="toggleProfileDropdown(event)" class="flex items-center gap-2 sm:gap-2.5 p-1 sm:p-1.5 rounded-xl hover:bg-cream-dark transition-colors focus:outline-none cursor-pointer">
                                    <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-forest text-white flex items-center justify-center font-bold text-xs ring-2 ring-white/80 shadow-xs">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                    </div>
                                    <div class="hidden sm:flex flex-col text-left">
                                        <span class="text-sm font-semibold text-text-primary leading-tight">{{ auth()->user()->name }}</span>
                                        <span class="text-[11px] text-text-muted leading-tight">
                                            {{ auth()->user()->isSuperAdmin() ? 'Super Admin' : (auth()->user()->isLibrarian() ? 'Pustakawan' : 'Anggota') }}
                                        </span>
                                    </div>
                                    <span class="material-symbols-outlined text-[16px] text-text-muted hidden sm:inline">expand_more</span>
                                </button>

                                <!-- Dropdown (z-50 inside z-30 header so it stays above the white card & discover section) -->
                                <div id="profileDropdownMenu" class="absolute right-0 top-full mt-2 w-56 bg-white rounded-2xl shadow-xl border border-border-light py-2 hidden group-hover:block hover:block z-50">
                                    <div class="px-3.5 py-2.5 border-b border-border-light">
                                        <span class="text-xs font-bold text-text-primary block truncate">{{ auth()->user()->name }}</span>
                                        <span class="text-[11px] text-text-muted block truncate">{{ auth()->user()->email }}</span>
                                    </div>

                                    @if(auth()->user()->isSuperAdmin())
                                    <a href="{{ route('users.index') }}" class="px-3.5 py-2 text-xs text-text-secondary hover:bg-surface-grey flex items-center gap-2 font-medium transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">manage_accounts</span>
                                        <span>Manajemen Pengguna</span>
                                    </a>
                                    @endif

                                    <a href="{{ route('loans.index') }}" class="px-3.5 py-2 text-xs text-text-secondary hover:bg-surface-grey flex items-center gap-2 font-medium transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">assignment</span>
                                        <span>{{ auth()->user()->isLibrarian() ? 'Sirkulasi Peminjaman' : 'Buku Pinjaman Saya' }}</span>
                                    </a>

                                    <a href="{{ route('ebooks.index') }}" class="px-3.5 py-2 text-xs text-text-secondary hover:bg-surface-grey flex items-center gap-2 font-medium transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">auto_stories</span>
                                        <span>Koleksi E-Book</span>
                                    </a>

                                    <div class="border-t border-border-light my-1"></div>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full px-3.5 py-2 text-left text-xs text-red-500 hover:bg-red-50 flex items-center gap-2 font-semibold transition-colors cursor-pointer">
                                            <span class="material-symbols-outlined text-[16px]">logout</span>
                                            <span>Keluar (Logout)</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @else
                            <div class="flex items-center gap-2">
                                <a href="{{ route('login') }}" class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-forest hover:bg-forest-light text-white text-xs font-semibold transition-colors">
                                    <span class="material-symbols-outlined text-[16px]">login</span>
                                    <span>Masuk</span>
                                </a>
                                <a href="{{ route('register') }}" class="hidden sm:flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-forest bg-white hover:bg-surface-grey border border-border-light transition-colors">
                                    <span class="material-symbols-outlined text-[16px]">person_add</span>
                                    <span>Daftar</span>
                                </a>
                            </div>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- White Content Panel -->
                <div class="bg-cream-light">
                    <div class="bg-white mx-2.5 sm:mx-8 rounded-2xl sm:rounded-3xl shadow-[0_2px_24px_rgba(0,0,0,0.04)] border border-border-light -mt-6 relative z-10 min-h-[calc(100vh-200px)]">
                        <div class="p-4 sm:p-8 lg:p-10">

                            <!-- Flash Success -->
                            @if(session('success'))
                            <div id="toast-success" class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-forest text-white flex items-center justify-center flex-shrink-0">
                                        <span class="material-symbols-outlined text-[20px]">check_circle</span>
                                    </div>
                                    <div>
                                        <span class="font-bold text-sm block">Berhasil:</span>
                                        <span class="text-xs text-green-700">{{ session('success') }}</span>
                                    </div>
                                </div>
                                <button onclick="document.getElementById('toast-success').remove()" type="button" class="text-green-600 hover:text-green-900 p-1">
                                    <span class="material-symbols-outlined text-[18px]">close</span>
                                </button>
                            </div>
                            @endif

                            <!-- Flash Error -->
                            @if(session('error') || $errors->any())
                            <div id="toast-error" class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-red-600 text-white flex items-center justify-center flex-shrink-0">
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

                            <!-- Page Content -->
                            @yield('content')

                        </div>
                    </div>

                    <!-- Footer spacing -->
                    <div class="h-10"></div>
                </div>
            </main>
        </div>
    </div>

    <!-- Global Delete Modal -->
    <div id="globalDeleteModal" class="fixed inset-0 z-50 hidden bg-black/40 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-xl border border-border-light flex flex-col gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-[26px]">delete_forever</span>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-text-primary">Konfirmasi Hapus Buku</h3>
                    <p class="text-xs text-text-muted">Tindakan ini permanen dan akan menghapus data buku dari database katalog.</p>
                </div>
            </div>

            <div class="bg-surface-grey p-3 rounded-xl text-xs text-text-secondary">
                Apakah Anda yakin ingin menghapus buku <strong id="deleteBookTitle"></strong>?
            </div>

            <form id="globalDeleteForm" method="POST" action="" class="flex items-center justify-end gap-2 pt-2">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 rounded-xl text-xs font-semibold text-text-secondary hover:bg-surface-grey transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-xl text-xs font-semibold bg-red-600 hover:bg-red-700 text-white shadow-sm transition-colors flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">delete</span>
                    <span>Hapus Sekarang</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Global Detail Modal -->
    <div id="globalDetailModal" class="fixed inset-0 z-50 hidden bg-black/40 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-2xl w-full p-6 shadow-xl border border-border-light flex flex-col max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-3 border-b border-border-light mb-4">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-forest text-[22px]">book_2</span>
                    <h3 class="font-bold text-lg text-text-primary">Detail Eksemplar Koleksi</h3>
                </div>
                <button type="button" onclick="closeDetailModal()" class="w-8 h-8 rounded-lg flex items-center justify-center text-text-muted hover:text-text-primary hover:bg-surface-grey">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>

            <div id="detailModalBody" class="flex flex-col gap-4">
                <div class="flex items-center justify-center py-12 text-text-muted">
                    <span class="material-symbols-outlined text-3xl animate-spin">sync</span>
                    <span class="ml-2 text-sm">Memuat informasi buku dari database...</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Global Search Modal -->
    <div id="globalSearchModal" class="fixed inset-0 z-50 hidden bg-black/40 flex items-start justify-center pt-20 p-4">
        <div class="bg-white rounded-3xl max-w-xl w-full shadow-2xl border border-border-light overflow-hidden">
            <div class="p-4 border-b border-border-light flex items-center gap-3">
                <span class="material-symbols-outlined text-text-muted text-[22px]">search</span>
                <input type="text" id="globalSearchInput" placeholder="Cari judul, ISBN, penulis, atau rak... (tekan ESC untuk menutup)"
                       class="w-full text-sm outline-none bg-transparent text-text-primary placeholder:text-text-muted"
                       onkeyup="if(event.key === 'Enter') executeGlobalSearch()">
                <button type="button" onclick="closeGlobalSearch()" class="text-text-muted hover:text-text-secondary text-xs px-2 py-1 rounded bg-surface-grey">
                    ESC
                </button>
            </div>
            <div class="p-3 bg-surface-grey text-[11px] text-text-muted flex items-center justify-between">
                <span>Tekan <strong class="text-text-primary">Enter</strong> untuk langsung menuju halaman hasil katalog.</span>
                <button type="button" onclick="executeGlobalSearch()" class="text-forest font-semibold hover:underline">
                    Cari di Katalog
                </button>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function initSidebarState() {
            const isDesktop = window.innerWidth >= 1024;
            const savedCollapsed = localStorage.getItem('bl_sidebar_collapsed') === 'true';
            const toggleIcon = document.getElementById('sidebarToggleIcon');

            if (isDesktop && savedCollapsed) {
                document.body.classList.add('sidebar-collapsed');
                if (toggleIcon) toggleIcon.textContent = 'menu';
            } else if (isDesktop) {
                document.body.classList.remove('sidebar-collapsed');
                if (toggleIcon) toggleIcon.textContent = 'menu_open';
            } else {
                document.body.classList.remove('sidebar-mobile-open');
                if (toggleIcon) toggleIcon.textContent = 'menu';
            }
        }

        function toggleSidebar(forceState) {
            const isDesktop = window.innerWidth >= 1024;
            const toggleIcon = document.getElementById('sidebarToggleIcon');
            const backdrop = document.getElementById('sidebarBackdrop');

            if (isDesktop) {
                const isCurrentlyCollapsed = document.body.classList.contains('sidebar-collapsed');
                const willCollapse = forceState !== undefined ? forceState : !isCurrentlyCollapsed;

                if (willCollapse) {
                    document.body.classList.add('sidebar-collapsed');
                    localStorage.setItem('bl_sidebar_collapsed', 'true');
                    if (toggleIcon) toggleIcon.textContent = 'menu';
                } else {
                    document.body.classList.remove('sidebar-collapsed');
                    localStorage.setItem('bl_sidebar_collapsed', 'false');
                    if (toggleIcon) toggleIcon.textContent = 'menu_open';
                }
            } else {
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
                const menu = document.getElementById('profileDropdownMenu');
                if (menu) menu.classList.add('hidden');
                if (window.innerWidth < 1024) {
                    toggleSidebar(false);
                }
            }
        });

        function toggleProfileDropdown(e) {
            if (e) e.stopPropagation();
            const menu = document.getElementById('profileDropdownMenu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }

        document.addEventListener('click', function(e) {
            const profileDropdown = document.getElementById('userProfileDropdown');
            const menu = document.getElementById('profileDropdownMenu');
            if (menu && profileDropdown && !profileDropdown.contains(e.target)) {
                menu.classList.add('hidden');
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
                <div class="flex items-center justify-center py-12 text-text-muted">
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
                    ? '<span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">Tersedia</span>'
                    : (book.status === 'Stok Kritis'
                        ? '<span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">Stok Kritis</span>'
                        : '<span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800">Habis</span>');

                body.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="flex flex-col items-center">
                            <img src="${coverUrl}" alt="${book.title}" class="w-full max-w-[150px] sm:max-w-[200px] h-48 sm:h-64 object-cover rounded-xl sm:rounded-2xl shadow-md border border-border-light">
                            <div class="mt-3 text-center">
                                <span class="text-[11px] text-text-muted font-mono block">${book.isbn}</span>
                                <div class="mt-1">${statusBadge}</div>
                            </div>
                        </div>
                        <div class="md:col-span-2 flex flex-col justify-between">
                            <div>
                                <span class="text-xs font-bold text-forest uppercase tracking-wider">${book.category}</span>
                                <h2 class="font-bold text-xl text-text-primary mt-1">${book.title}</h2>
                                ${book.subtitle ? `<p class="text-xs text-text-muted italic mt-0.5">${book.subtitle}</p>` : ''}

                                <div class="grid grid-cols-2 gap-3 mt-4 text-xs">
                                    <div class="bg-surface-grey p-2.5 rounded-xl">
                                        <span class="text-text-muted block text-[10px] uppercase font-bold">Penulis</span>
                                        <strong class="text-text-primary">${book.author}</strong>
                                    </div>
                                    <div class="bg-surface-grey p-2.5 rounded-xl">
                                        <span class="text-text-muted block text-[10px] uppercase font-bold">Penerbit</span>
                                        <strong class="text-text-primary">${book.publisher} (${book.year})</strong>
                                    </div>
                                    <div class="bg-surface-grey p-2.5 rounded-xl">
                                        <span class="text-text-muted block text-[10px] uppercase font-bold">Lokasi Rak</span>
                                        <strong class="text-text-primary">${book.shelf_location}</strong>
                                    </div>
                                    <div class="bg-surface-grey p-2.5 rounded-xl">
                                        <span class="text-text-muted block text-[10px] uppercase font-bold">Stok Fisik</span>
                                        <strong class="text-forest text-sm">${book.stock}</strong> <span class="text-text-muted">/ ${book.total_copies} eksemplar</span>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <span class="text-xs font-bold text-text-secondary block mb-1">Sinopsis:</span>
                                    <p class="text-xs text-text-secondary leading-relaxed bg-surface-grey p-3 rounded-xl">
                                        ${book.description || 'Tidak ada deskripsi rinci untuk buku ini.'}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between gap-3 pt-4 border-t border-border-light mt-4">
                                <form method="POST" action="/books/${book.id}/stock" class="flex items-center gap-1.5">
                                    <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                                    <span class="text-xs font-medium text-text-muted mr-1">Penyesuaian Stok:</span>
                                    <button type="submit" name="delta" value="-1" class="w-8 h-8 rounded-xl bg-surface-grey hover:bg-cream-dark text-text-primary font-bold flex items-center justify-center transition-colors">
                                        -
                                    </button>
                                    <span class="px-2 text-xs font-bold text-text-primary">${book.stock}</span>
                                    <button type="submit" name="delta" value="1" class="w-8 h-8 rounded-xl bg-forest hover:bg-forest-light text-white font-bold flex items-center justify-center transition-colors">
                                        +
                                    </button>
                                </form>

                                <div class="flex items-center gap-2">
                                    <a href="/books/${book.id}/edit" class="px-3 py-1.5 rounded-xl bg-forest hover:bg-forest-light text-white text-xs font-semibold flex items-center gap-1 transition-colors">
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
