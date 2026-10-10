<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membaca: {{ $book->title }} · Athenaeum Digital Reader</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600&family=Inter:wght@400;500;600;700&family=Lora:ital,wght@0,400;0,500;0,600;1,400&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

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
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        headline: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                        serif: ['Lora', 'Georgia', 'serif'],
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
<body id="readerBody" class="bg-[#faf8f5] text-[#2c332e] font-serif antialiased min-h-screen transition-colors duration-200">

    <!-- Sticky Reading Top Toolbar -->
    <header id="readerHeader" class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-[#e5dfd5] px-4 sm:px-8 h-16 flex items-center justify-between shadow-xs">
        <div class="flex items-center gap-3">
            <a href="{{ route('ebooks.index') }}"
               class="p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors flex items-center justify-center"
               title="Kembali ke Galeri E-Book">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
            </a>
            <div class="flex flex-col">
                <h1 class="font-headline font-bold text-sm text-slate-900 line-clamp-1 max-w-xs sm:max-w-md">
                    {{ $book->title }}
                </h1>
                <span class="text-[11px] text-slate-500 font-sans line-clamp-1">
                    {{ $book->author }} · {{ $book->category }}
                </span>
            </div>
        </div>

        <!-- Toolbar Kontrol Bacaan -->
        <div class="flex items-center gap-2 font-sans">
            <!-- Ukuran Teks -->
            <div class="flex items-center bg-slate-100 rounded-xl p-1 border border-slate-200">
                <button type="button"
                        onclick="adjustFontSize(-2)"
                        title="Perkecil Ukuran Huruf"
                        class="px-2.5 py-1 rounded-lg text-xs font-bold text-slate-700 hover:bg-white transition-colors">
                    A-
                </button>
                <button type="button"
                        onclick="adjustFontSize(2)"
                        title="Perbesar Ukuran Huruf"
                        class="px-2.5 py-1 rounded-lg text-xs font-bold text-slate-700 hover:bg-white transition-colors">
                    A+
                </button>
            </div>

            <!-- Mode Tema Pembaca: Terang / Sepia / Gelap -->
            <div class="flex items-center bg-slate-100 rounded-xl p-1 border border-slate-200">
                <button type="button"
                        onclick="setReaderTheme('light')"
                        title="Mode Terang (Putih)"
                        class="w-7 h-7 rounded-lg bg-white border border-slate-200 text-slate-800 flex items-center justify-center text-xs font-bold shadow-xs">
                    ☀️
                </button>
                <button type="button"
                        onclick="setReaderTheme('sepia')"
                        title="Mode Sepia (Hangat)"
                        class="w-7 h-7 rounded-lg bg-[#faf8f5] text-[#705e44] flex items-center justify-center text-xs font-bold">
                    📜
                </button>
                <button type="button"
                        onclick="setReaderTheme('dark')"
                        title="Mode Gelap (Malam)"
                        class="w-7 h-7 rounded-lg bg-slate-800 text-slate-200 flex items-center justify-center text-xs font-bold">
                    🌙
                </button>
            </div>
        </div>
    </header>

    <!-- Reading Progress Indicator -->
    <div class="fixed top-16 left-0 right-0 h-1 bg-slate-200 z-50">
        <div id="progressBar" class="h-full bg-emerald-600 transition-all duration-100 w-0"></div>
    </div>

    <!-- Main Content Reader Canvas -->
    <main class="max-w-3xl mx-auto px-6 py-12 sm:py-16">
        
        <!-- Header Naskah -->
        <div class="mb-12 pb-8 border-b border-[#e5dfd5] text-center">
            <span class="text-xs font-sans uppercase font-bold tracking-widest text-[#00652c] block mb-2">
                Naskah Digital Athenaeum Library
            </span>
            <h1 class="font-headline font-extrabold text-3xl sm:text-4xl text-slate-900 tracking-tight leading-tight mb-3">
                {{ $book->title }}
            </h1>
            @if($book->subtitle)
                <p class="text-base text-slate-600 italic font-serif mb-3">{{ $book->subtitle }}</p>
            @endif
            <div class="text-xs font-sans text-slate-500 flex items-center justify-center gap-3">
                <span>Penulis: <strong class="text-slate-800">{{ $book->author }}</strong></span>
                <span>·</span>
                <span>Tahun: {{ $book->year }}</span>
                <span>·</span>
                <span>ISBN: {{ $book->isbn }}</span>
            </div>
        </div>

        <!-- Isi Naskah E-Book -->
        <article id="readerContent" class="text-lg leading-relaxed space-y-6">
            <div class="p-4 rounded-xl bg-emerald-50/60 border border-emerald-100 text-xs font-sans text-emerald-900 mb-6 flex items-start gap-2.5">
                <span class="material-symbols-outlined text-emerald-700 text-[20px] shrink-0 mt-0.5">verified</span>
                <div>
                    <strong class="font-bold block">Akses Baca Mandiri Anggota:</strong>
                    <span>Koleksi ini tersedia bebas untuk seluruh pengunjung dan mahasiswa yang terdaftar di Athenaeum Library System.</span>
                </div>
            </div>

            <p class="first-letter:text-5xl first-letter:font-bold first-letter:float-left first-letter:mr-3 first-letter:text-emerald-800">
                {{ $book->description ?: 'Buku ini merupakan salah satu pustaka unggulan yang tersimpan dalam koleksi repositori digital Athenaeum. Penulisan naskah ini mengusung pendekatan analitis yang mendalam terhadap kajian keilmuan dan sastra.' }}
            </p>

            <h2 class="font-headline font-bold text-2xl text-slate-900 pt-6 pb-2 border-b border-slate-200">
                Bab 1: Dasar Pemikiran dan Latar Belakang
            </h2>

            <p>
                Kajian pustaka yang komprehensif memerlukan telaah kritis terhadap sumber-sumber primer dan sekunder. Di era digitalisasi katalog ini, kemudahan akses informasi menjadi kunci utama dalam mendukung riset akademik mahasiswa dan cendekiawan.
            </p>

            <p>
                Melalui sistem klasifikasi Dewey Decimal (DDC), setiap judul ditempatkan pada konteks disiplin ilmu yang tepat, memungkinkan penelusuran silang antar tema keilmuan dengan efisiensi tinggi.
            </p>

            <h2 class="font-headline font-bold text-2xl text-slate-900 pt-6 pb-2 border-b border-slate-200">
                Bab 2: Intisari Kajian &amp; Diskusi Metodologis
            </h2>

            <p>
                Penelitian dalam naskah ini membuktikan bahwa integrasi teknologi basis data modern seperti Eloquent ORM mampu mereduksi hambatan birokrasi dalam sirkulasi perpustakaan klasik, menjadikan proses peminjaman transparan dan terukur secara instan.
            </p>

            <blockquote class="pl-4 border-l-4 border-emerald-600 italic text-slate-700 my-6 bg-slate-50 py-3 pr-4 rounded-r-xl font-sans text-sm">
                "Perpustakaan bukanlah sekadar tempat menyimpan buku, melainkan ruang bertemunya gagasan lintas generasi."
            </blockquote>

            <h2 class="font-headline font-bold text-2xl text-slate-900 pt-6 pb-2 border-b border-slate-200">
                Bab 3: Catatan Penutup &amp; Konklusi
            </h2>

            <p>
                Dengan ketersediaan naskah digital ini, pembaca dapat memperkaya wawasan keilmuan kapan saja dan di mana saja. Teruslah mengeksplorasi katalog digital Athenaeum untuk menemukan permata pustaka lainnya.
            </p>
        </article>

        <!-- Navigasi Bawah Naskah -->
        <div class="mt-16 pt-8 border-t border-[#e5dfd5] flex flex-col sm:flex-row items-center justify-between gap-4 font-sans text-xs">
            <span class="text-slate-500">
                Halaman Digital: 1 - {{ $book->ebook_pages ?: 150 }} dari repositori terverifikasi
            </span>
            <div class="flex items-center gap-2">
                <a href="{{ route('books.show', $book) }}"
                   class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold transition-colors">
                    Lihat Detail Buku Fisik
                </a>
                <a href="{{ route('ebooks.index') }}"
                   class="px-4 py-2 rounded-xl bg-[#15803d] hover:bg-[#16a34a] text-white font-semibold transition-colors">
                    Kembali ke Daftar E-Book
                </a>
            </div>
        </div>

    </main>

    <!-- JavaScript Interaktif Pembaca -->
    <script>
        let currentSize = 18;

        function adjustFontSize(delta) {
            currentSize = Math.max(14, Math.min(26, currentSize + delta));
            document.getElementById('readerContent').style.fontSize = currentSize + 'px';
        }

        function setReaderTheme(theme) {
            const body = document.getElementById('readerBody');
            const header = document.getElementById('readerHeader');
            if (theme === 'dark') {
                body.className = 'bg-slate-900 text-slate-100 font-serif antialiased min-h-screen transition-colors duration-200';
                header.className = 'sticky top-0 z-40 bg-slate-900/95 backdrop-blur-md border-b border-slate-800 px-4 sm:px-8 h-16 flex items-center justify-between shadow-xs text-white';
            } else if (theme === 'sepia') {
                body.className = 'bg-[#faf8f5] text-[#2c332e] font-serif antialiased min-h-screen transition-colors duration-200';
                header.className = 'sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-[#e5dfd5] px-4 sm:px-8 h-16 flex items-center justify-between shadow-xs';
            } else {
                body.className = 'bg-white text-slate-900 font-serif antialiased min-h-screen transition-colors duration-200';
                header.className = 'sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200 px-4 sm:px-8 h-16 flex items-center justify-between shadow-xs';
            }
        }

        // Hitung progres membaca saat scroll
        window.addEventListener('scroll', function() {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            document.getElementById('progressBar').style.width = scrolled + '%';
        });
    </script>
</body>
</html>
