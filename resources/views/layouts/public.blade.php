<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <title>@yield('title', 'Beranda Perpustakaan') · {{ config('library.name', 'Athenaeum Library') }}</title>
    @include('partials.head-assets')
    @stack('styles')
</head>
<body class="bg-cream-light text-text-primary font-sans antialiased min-h-screen flex flex-col justify-between selection:bg-[#2373F4] selection:text-white">

    <!-- Top Notice / Announcement Bar (Subtle) -->
    <div class="bg-forest text-emerald-100/90 text-xs py-2 px-4 border-b border-forest-light">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
            <div class="flex items-center gap-2 truncate">
                <span class="inline-flex items-center justify-center w-2 h-2 rounded-full bg-emerald-400"></span>
                <span class="truncate">{{ config('library.tagline', 'Katalog, sirkulasi, dan koleksi digital perpustakaan dalam satu pintu.') }}</span>
            </div>
            <div class="hidden sm:flex items-center gap-4 text-[11px] shrink-0 font-medium">
                @if(config('library.contact.hours'))
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">schedule</span>
                        <span>{{ config('library.contact.hours') }}</span>
                    </span>
                @endif
                <a href="{{ route('pages.help') }}" class="hover:text-white transition-colors flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">help</span>
                    <span>Pusat Bantuan</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Header Navbar -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-border-light shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group shrink-0">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-[#2373F4] to-[#1A5EC4] flex items-center justify-center text-white shadow-sm group-hover:scale-105 transition-transform">
                    <span class="material-symbols-outlined text-[22px]">local_library</span>
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-base sm:text-lg text-text-primary tracking-tight leading-none group-hover:text-[#2373F4] transition-colors">
                        {{ config('library.name', 'Athenaeum Library') }}
                    </span>
                    <span class="text-[10px] uppercase font-bold tracking-widest text-text-muted mt-1">
                        Sistem Perpustakaan
                    </span>
                </div>
            </a>

            <!-- Desktop Navigation Links (Matches Flowchart Navbar Branch) -->
            <nav class="hidden lg:flex items-center gap-1 text-sm font-medium text-text-secondary">
                <a href="{{ route('home') }}"
                   class="px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('home') ? 'text-[#2373F4] font-semibold bg-[#2373F4]/10' : 'hover:text-text-primary hover:bg-surface-grey' }}">
                    Beranda
                </a>
                <a href="{{ route('pages.about') }}"
                   class="px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('pages.about') ? 'text-[#2373F4] font-semibold bg-[#2373F4]/10' : 'hover:text-text-primary hover:bg-surface-grey' }}">
                    Tentang Kami
                </a>
                <a href="{{ route('pages.contact') }}"
                   class="px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('pages.contact') ? 'text-[#2373F4] font-semibold bg-[#2373F4]/10' : 'hover:text-text-primary hover:bg-surface-grey' }}">
                    Kontak
                </a>
                <a href="{{ route('pages.librarians') }}"
                   class="px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('pages.librarians') ? 'text-[#2373F4] font-semibold bg-[#2373F4]/10' : 'hover:text-text-primary hover:bg-surface-grey' }}">
                    Pustakawan
                </a>
                <a href="{{ route('pages.help') }}"
                   class="px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('pages.help') ? 'text-[#2373F4] font-semibold bg-[#2373F4]/10' : 'hover:text-text-primary hover:bg-surface-grey' }}">
                    Chat / Bantuan
                </a>
                <a href="{{ route('news.index') }}"
                   class="px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('news.*') ? 'text-[#2373F4] font-semibold bg-[#2373F4]/10' : 'hover:text-text-primary hover:bg-surface-grey' }}">
                    Berita
                </a>
                <a href="{{ route('events.index') }}"
                   class="px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('events.*') ? 'text-[#2373F4] font-semibold bg-[#2373F4]/10' : 'hover:text-text-primary hover:bg-surface-grey' }}">
                    Acara
                </a>
            </nav>

            <!-- Right Action / User State -->
            <div class="hidden sm:flex items-center gap-2.5">
                @guest
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 rounded-xl text-xs font-semibold text-text-primary hover:bg-surface-grey border border-border-light transition-colors flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px]">login</span>
                        <span>Masuk</span>
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 rounded-xl text-xs font-semibold bg-[#2373F4] hover:bg-[#1A5EC4] text-white shadow-xs transition-colors flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px]">person_add</span>
                        <span>Daftar</span>
                    </a>
                @else
                    <a href="{{ route('dashboard') }}"
                       class="px-4 py-2 rounded-xl text-xs font-semibold bg-forest hover:bg-forest-light text-white shadow-xs transition-colors flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px]">dashboard</span>
                        <span>Dashboard Katalog</span>
                    </a>
                    <div class="flex items-center gap-2 pl-2 border-l border-border-light">
                        <div class="w-8 h-8 rounded-full bg-forest text-white flex items-center justify-center font-bold text-xs ring-1 ring-border-light">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" title="Keluar Akun" class="p-1.5 rounded-lg text-text-muted hover:text-red-600 hover:bg-red-50 transition-colors cursor-pointer">
                                <span class="material-symbols-outlined text-[18px]">logout</span>
                            </button>
                        </form>
                    </div>
                @endguest
            </div>

            <!-- Mobile Hamburger Button -->
            <button type="button" onclick="toggleMobileNav()"
                    class="lg:hidden p-2 rounded-xl text-text-secondary hover:bg-surface-grey transition-colors cursor-pointer"
                    aria-label="Buka Menu Navigasi">
                <span id="mobileMenuIcon" class="material-symbols-outlined text-[24px]">menu</span>
            </button>
        </div>

        <!-- Mobile Drawer Menu -->
        <div id="mobileNavMenu" class="hidden lg:hidden border-t border-border-light bg-white px-4 pt-3 pb-5 space-y-2 shadow-lg">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('home') ? 'text-[#2373F4] bg-[#2373F4]/10 font-semibold' : 'text-text-secondary hover:bg-surface-grey' }}">
                Beranda
            </a>
            <a href="{{ route('pages.about') }}" class="block px-3 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('pages.about') ? 'text-[#2373F4] bg-[#2373F4]/10 font-semibold' : 'text-text-secondary hover:bg-surface-grey' }}">
                Tentang Kami
            </a>
            <a href="{{ route('pages.contact') }}" class="block px-3 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('pages.contact') ? 'text-[#2373F4] bg-[#2373F4]/10 font-semibold' : 'text-text-secondary hover:bg-surface-grey' }}">
                Kontak
            </a>
            <a href="{{ route('pages.librarians') }}" class="block px-3 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('pages.librarians') ? 'text-[#2373F4] bg-[#2373F4]/10 font-semibold' : 'text-text-secondary hover:bg-surface-grey' }}">
                Pustakawan
            </a>
            <a href="{{ route('pages.help') }}" class="block px-3 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('pages.help') ? 'text-[#2373F4] bg-[#2373F4]/10 font-semibold' : 'text-text-secondary hover:bg-surface-grey' }}">
                Chat / Bantuan
            </a>
            <a href="{{ route('news.index') }}" class="block px-3 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('news.*') ? 'text-[#2373F4] bg-[#2373F4]/10 font-semibold' : 'text-text-secondary hover:bg-surface-grey' }}">
                Berita
            </a>
            <a href="{{ route('events.index') }}" class="block px-3 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('events.*') ? 'text-[#2373F4] bg-[#2373F4]/10 font-semibold' : 'text-text-secondary hover:bg-surface-grey' }}">
                Acara
            </a>

            <div class="pt-3 border-t border-border-light flex flex-col gap-2">
                @guest
                    <a href="{{ route('login') }}" class="w-full py-2.5 rounded-xl text-center text-xs font-semibold text-text-primary bg-surface-grey hover:bg-border-light transition-colors">
                        Masuk ke Akun
                    </a>
                    <a href="{{ route('register') }}" class="w-full py-2.5 rounded-xl text-center text-xs font-semibold bg-[#2373F4] text-white hover:bg-[#1A5EC4] transition-colors">
                        Daftar Anggota Baru
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="w-full py-2.5 rounded-xl text-center text-xs font-semibold bg-forest text-white hover:bg-forest-light transition-colors flex items-center justify-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px]">dashboard</span>
                        <span>Buka Dashboard Sirkulasi</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full py-2 rounded-xl text-center text-xs font-semibold text-red-600 hover:bg-red-50 transition-colors">
                            Keluar (Logout)
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </header>

    <!-- Main Public Content -->
    <main class="flex-1 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6">
            @include('partials.flash')
            @yield('content')
        </div>
    </main>

    <!-- Public Footer -->
    <footer class="bg-forest text-slate-100 pt-14 pb-8 mt-16 border-t border-forest-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 pb-12 border-b border-forest-light">
                <!-- Col 1: About -->
                <div class="lg:col-span-2 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-[#2373F4] text-white flex items-center justify-center font-bold shadow-xs">
                            <span class="material-symbols-outlined text-[20px]">local_library</span>
                        </div>
                        <span class="font-bold text-lg text-white">{{ config('library.name', 'Athenaeum Library') }}</span>
                    </div>
                    <p class="text-xs text-emerald-100/70 leading-relaxed max-w-sm">
                        Layanan perpustakaan terpadu yang memadukan sirkulasi buku fisik, katalog digital OPAC, repositori akademik, e-journal, dan e-book dalam satu sistem modern.
                    </p>
                    <div class="flex items-center gap-2 pt-2">
                        <a href="{{ route('pages.help') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-medium text-white transition-colors">
                            <span class="material-symbols-outlined text-[15px]">support_agent</span>
                            <span>Chat Bantuan</span>
                        </a>
                        <a href="{{ route('pages.contact') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-medium text-white transition-colors">
                            <span class="material-symbols-outlined text-[15px]">contact_support</span>
                            <span>Hubungi Kami</span>
                        </a>
                    </div>
                </div>

                <!-- Col 2: Layanan Koleksi -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-emerald-300 mb-3">Layanan Koleksi</h4>
                    <ul class="space-y-2 text-xs text-emerald-100/80">
                        <li><a href="{{ route('books.index') }}" class="hover:text-white transition-colors">Katalog Buku (OPAC)</a></li>
                        <li><a href="{{ route('ebooks.index') }}" class="hover:text-white transition-colors">E-Book Digital</a></li>
                        <li><a href="{{ route('cjs.index') }}" class="hover:text-white transition-colors">CJS per Prodi</a></li>
                        <li><a href="{{ route('categories.index') }}" class="hover:text-white transition-colors">Klasifikasi DDC</a></li>
                    </ul>
                </div>

                <!-- Col 3: Informasi & Publikasi -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-emerald-300 mb-3">Informasi</h4>
                    <ul class="space-y-2 text-xs text-emerald-100/80">
                        <li><a href="{{ route('pages.about') }}" class="hover:text-white transition-colors">Tentang Perpustakaan</a></li>
                        <li><a href="{{ route('pages.librarians') }}" class="hover:text-white transition-colors">Profil Pustakawan</a></li>
                        <li><a href="{{ route('news.index') }}" class="hover:text-white transition-colors">Berita Terkini</a></li>
                        <li><a href="{{ route('events.index') }}" class="hover:text-white transition-colors">Agenda & Acara</a></li>
                    </ul>
                </div>

                <!-- Col 4: Jam & Kontak -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-emerald-300 mb-3">Kontak & Jam Buka</h4>
                    <div class="space-y-2 text-xs text-emerald-100/80">
                        @if(config('library.contact.hours'))
                            <p class="flex items-start gap-1.5">
                                <span class="material-symbols-outlined text-[15px] text-emerald-300 shrink-0">schedule</span>
                                <span>{{ config('library.contact.hours') }}</span>
                            </p>
                        @endif
                        @if(config('library.contact.email'))
                            <p class="flex items-start gap-1.5">
                                <span class="material-symbols-outlined text-[15px] text-emerald-300 shrink-0">mail</span>
                                <a href="mailto:{{ config('library.contact.email') }}" class="hover:text-white">{{ config('library.contact.email') }}</a>
                            </p>
                        @endif
                        @if(config('library.contact.phone'))
                            <p class="flex items-start gap-1.5">
                                <span class="material-symbols-outlined text-[15px] text-emerald-300 shrink-0">call</span>
                                <span>{{ config('library.contact.phone') }}</span>
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-[11px] text-emerald-200/60">
                <p>&copy; {{ date('Y') }} {{ config('library.name', 'Athenaeum Library') }}. Seluruh hak cipta dilindungi.</p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('pages.about') }}" class="hover:text-white transition-colors">Kebijakan Sirkulasi</a>
                    <a href="{{ route('pages.help') }}" class="hover:text-white transition-colors">Bantuan Pemustaka</a>
                    <a href="{{ route('dashboard') }}" class="hover:text-white transition-colors">Dashboard Staf</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Drawer Script -->
    <script>
        function toggleMobileNav() {
            const menu = document.getElementById('mobileNavMenu');
            const icon = document.getElementById('mobileMenuIcon');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                icon.textContent = 'close';
            } else {
                menu.classList.add('hidden');
                icon.textContent = 'menu';
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
