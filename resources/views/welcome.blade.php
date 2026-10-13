<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athenaeum Library System: Repositori Katalog &amp; Sirkulasi Buku</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Fira+Code:wght@400;500;600&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
                        surface: '#f8f9ff',
                        'text-main': '#121c2a',
                        'text-muted': '#6f7a6e',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        headline: ['DM Sans', 'Inter', 'sans-serif'],
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
    </style>
</head>
<body class="bg-[#031d10] text-slate-100 font-sans antialiased selection:bg-emerald-600 selection:text-white min-h-screen flex flex-col justify-between">

    <!-- Background Atmospheric Classical Library Image with Gradient Overlays -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <img src="https://images.unsplash.com/photo-1507842229450-7977a4966ad5?auto=format&fit=crop&w=1920&q=80"
             alt="Classical Athenaeum Library Grand Hall"
             class="w-full h-full object-cover object-center filter brightness-[0.4] contrast-[1.15] scale-105">
        <div class="absolute inset-0 bg-gradient-to-b from-[#021d10]/95 via-[#032916]/80 to-[#02150b]/95 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-radial from-transparent via-[#02180d]/60 to-[#010e07]/90"></div>
    </div>

    <!-- Navigation Bar -->
    <header class="relative z-20 w-full border-b border-white/10 bg-black/30 backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#15803d] to-[#00652c] flex items-center justify-center text-white shadow-lg group-hover:scale-105 transition-transform border border-emerald-400/30">
                    <span class="material-symbols-outlined text-[24px]">local_library</span>
                </div>
                <div class="flex flex-col">
                    <span class="font-headline font-bold text-lg text-white tracking-tight leading-none group-hover:text-emerald-300 transition-colors">
                        Athenaeum
                    </span>
                    <span class="text-[10px] uppercase text-emerald-400 font-bold tracking-widest mt-1">
                        Library System
                    </span>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-emerald-100/80">
                <a href="{{ route('dashboard') }}" class="hover:text-white transition-colors">Dashboard</a>
                <a href="{{ route('books.index') }}" class="hover:text-white transition-colors">Katalog Koleksi</a>
                <a href="{{ route('categories.index') }}" class="hover:text-white transition-colors">Klasifikasi DDC</a>
                <a href="{{ route('inventory.index') }}" class="hover:text-white transition-colors">Audit Rak</a>
            </nav>
            <div class="flex items-center gap-3">
                @guest
                <a href="{{ route('login') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-semibold text-xs sm:text-sm border border-white/20 transition-all hover:border-white/40">
                    <span class="material-symbols-outlined text-[18px] text-emerald-300">key</span>
                    <span>Masuk Pustakawan</span>
                </a>
                @endguest
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#15803d] hover:bg-[#16a34a] text-white font-semibold text-xs sm:text-sm shadow-lg hover:shadow-emerald-900/40 transition-all border border-emerald-400/30 active:scale-95">
                    <span class="material-symbols-outlined text-[18px]">dashboard</span>
                    <span>Dashboard Katalog</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Landing Hero Section -->
    <main class="relative z-10 flex-1 flex flex-col justify-center max-w-7xl mx-auto px-6 py-16 sm:py-24">
        <div class="max-w-3xl">
            <!-- Scholarly Badge -->
            <div class="inline-flex items-center gap-2.5 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-emerald-300 text-xs font-semibold mb-6 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="tracking-wide">Klasifikasi Dewey Decimal · Preservasi Khazanah Pustaka</span>
            </div>

            <!-- Grand Headline -->
            <h1 class="font-headline text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-[1.15] mb-6">
                Katalogisasi Klasik &amp; Preservasi Digital <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 via-teal-200 to-amber-200">Athenaeum</span>
            </h1>

            <!-- Scholarly Description -->
            <p class="text-base sm:text-lg text-emerald-100/90 leading-relaxed font-normal mb-8 max-w-2xl">
                Platform otomasi perpustakaan berstandar akademis yang mengintegrasikan pendataan eksemplar, pencatatan rak penyimpanan, serta penelusuran relasi basis data menggunakan <span class="text-white font-semibold underline decoration-emerald-400 underline-offset-4">Laravel 12 &amp; Eloquent ORM</span>.
            </p>

            <!-- Action CTAs -->
            <div class="flex flex-wrap items-center gap-4 mb-12">
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center gap-2.5 px-6 py-3.5 rounded-xl bg-gradient-to-r from-[#15803d] to-[#00652c] hover:from-[#16a34a] hover:to-[#007b36] text-white font-bold text-sm shadow-xl hover:shadow-2xl hover:scale-[1.02] transition-all border border-emerald-400/40">
                    <span class="material-symbols-outlined text-[20px]">explore</span>
                    <span>Jelajahi Dashboard Katalog</span>
                </a>

                <a href="{{ route('books.index') }}"
                   class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-semibold text-sm border border-white/20 transition-all hover:border-white/40">
                    <span class="material-symbols-outlined text-[20px] text-emerald-300">menu_book</span>
                    <span>Daftar Buku Terdaftar</span>
                </a>
            </div>

            <!-- Features Highlights Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-8 border-t border-white/15">
                <div class="p-4 rounded-xl bg-white/5 backdrop-blur-md border border-white/10 hover:border-emerald-400/30 transition-colors">
                    <div class="flex items-center gap-2 text-emerald-300 font-bold text-xs uppercase tracking-wider mb-1">
                        <span class="material-symbols-outlined text-[18px]">category</span>
                        <span>DDC Classification</span>
                    </div>
                    <p class="text-xs text-emerald-100/70 leading-relaxed">
                        Pengelompokan sistematis Dewey Decimal 23rd Edition untuk penataan subjek pustaka.
                    </p>
                </div>

                <div class="p-4 rounded-xl bg-white/5 backdrop-blur-md border border-white/10 hover:border-emerald-400/30 transition-colors">
                    <div class="flex items-center gap-2 text-emerald-300 font-bold text-xs uppercase tracking-wider mb-1">
                        <span class="material-symbols-outlined text-[18px]">shelves</span>
                        <span>Audit Rak Fisik</span>
                    </div>
                    <p class="text-xs text-emerald-100/70 leading-relaxed">
                        Pelacakan ketersediaan stok buku pada tiap lorong dan rak penyimpanan perpustakaan.
                    </p>
                </div>

                <div class="p-4 rounded-xl bg-white/5 backdrop-blur-md border border-white/10 hover:border-emerald-400/30 transition-colors">
                    <div class="flex items-center gap-2 text-emerald-300 font-bold text-xs uppercase tracking-wider mb-1">
                        <span class="material-symbols-outlined text-[18px]">database</span>
                        <span>Eloquent &amp; SQLite</span>
                    </div>
                    <p class="text-xs text-emerald-100/70 leading-relaxed">
                        Arsitektur ORM murni tanpa raw SQL, siap ekspor format CSV dan MySQL .sql dump.
                    </p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="relative z-20 w-full border-t border-white/10 bg-black/40 backdrop-blur-xl py-6">
        <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-emerald-100/60 font-mono">
            <div>
                Athenaeum Library System · Laravel {{ app()->version() }} · PHP {{ PHP_MAJOR_VERSION }}.{{ PHP_MINOR_VERSION }}
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="hover:text-emerald-300 transition-colors">Dashboard</a>
                <a href="{{ route('books.index') }}" class="hover:text-emerald-300 transition-colors">Katalog</a>
                <a href="{{ route('settings.index') }}" class="hover:text-emerald-300 transition-colors">Pengaturan</a>
            </div>
        </div>
    </footer>

</body>
</html>
