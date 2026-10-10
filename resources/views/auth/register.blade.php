<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Akun Pustakawan · Athenaeum Library System</title>

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
                        surface: '#f8f9ff',
                        'text-main': '#121c2a',
                        'text-muted': '#475569',
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
    </style>
</head>
<body class="bg-[#f8f9ff] text-[#121c2a] font-sans antialiased min-h-screen flex flex-col justify-between selection:bg-emerald-600 selection:text-white">

    <!-- Header Sederhana -->
    <header class="w-full border-b border-[#e6eeff] bg-white/90 backdrop-blur-md sticky top-0 z-30">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('welcome') }}" class="flex items-center gap-2.5 group">
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

            <div class="flex items-center gap-2">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-[#00652c] bg-[#eff4ff] hover:bg-[#dee9fc] transition-colors">
                    <span class="material-symbols-outlined text-[16px]">login</span>
                    <span>Sudah Punya Akun? Masuk</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Konten Utama Halaman Registrasi -->
    <main class="flex-1 flex items-center justify-center px-4 py-10 sm:py-14">
        <div class="w-full max-w-lg">

            <!-- Card Utama Formulir Registrasi -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-[#e6eeff]">
                
                <!-- Identitas & Judul Formulir -->
                <div class="mb-6 text-center">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#00652c] border border-emerald-100 flex items-center justify-center mx-auto mb-3 shadow-xs">
                        <span class="material-symbols-outlined text-[26px]">person_add</span>
                    </div>
                    <h1 class="font-headline font-bold text-2xl text-[#121c2a] tracking-tight">
                        Daftar Akun Baru
                    </h1>
                    <p class="text-xs text-[#475569] mt-1.5 leading-relaxed">
                        Pendaftaran akun perpustakaan untuk pengunjung, mahasiswa, dan staf.
                    </p>
                </div>

                <!-- Notifikasi Kesalahan Validasi Global -->
                @if($errors->any())
                <div class="mb-5 p-3.5 bg-rose-50 border border-rose-200 text-rose-900 rounded-2xl flex items-start gap-2.5 text-xs">
                    <span class="material-symbols-outlined text-rose-700 text-[18px] shrink-0 mt-0.5">error</span>
                    <div>
                        <strong class="font-semibold block">Gagal Mendaftar:</strong>
                        <ul class="list-disc list-inside space-y-0.5 mt-0.5">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <!-- Form Registrasi -->
                <form id="registerForm" method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Input Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-xs font-semibold text-[#121c2a] mb-1.5">
                            Nama Lengkap
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <span class="material-symbols-outlined text-[18px]">badge</span>
                            </span>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   required
                                   autocomplete="name"
                                   autofocus
                                   placeholder="Contoh: Raden Ayu Kartika"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-50 border {{ $errors->has('name') ? 'border-rose-400 bg-rose-50/30' : 'border-[#dee9fc]' }} text-sm text-[#121c2a] placeholder:text-slate-400 focus:bg-white focus:border-[#15803d] focus:ring-2 focus:ring-emerald-500/20 focus:outline-none transition-all">
                        </div>
                        @error('name')
                            <p class="text-[11px] text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Surel (Email) -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-[#121c2a] mb-1.5">
                            Alamat Surel Resmi
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <span class="material-symbols-outlined text-[18px]">mail</span>
                            </span>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="email"
                                   placeholder="nama@athenaeum.test"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-50 border {{ $errors->has('email') ? 'border-rose-400 bg-rose-50/30' : 'border-[#dee9fc]' }} text-sm text-[#121c2a] placeholder:text-slate-400 focus:bg-white focus:border-[#15803d] focus:ring-2 focus:ring-emerald-500/20 focus:outline-none transition-all">
                        </div>
                        @error('email')
                            <p class="text-[11px] text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Kata Sandi & Konfirmasi (2 Kolom di Desktop) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Kata Sandi -->
                        <div>
                            <label for="password" class="block text-xs font-semibold text-[#121c2a] mb-1.5">
                                Kata Sandi
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <span class="material-symbols-outlined text-[18px]">lock</span>
                                </span>
                                <input type="password"
                                       id="password"
                                       name="password"
                                       required
                                       minlength="8"
                                       autocomplete="new-password"
                                       placeholder="Minimal 8 karakter"
                                       class="w-full pl-10 pr-10 py-2.5 rounded-xl bg-slate-50 border {{ $errors->has('password') ? 'border-rose-400 bg-rose-50/30' : 'border-[#dee9fc]' }} text-sm text-[#121c2a] placeholder:text-slate-400 focus:bg-white focus:border-[#15803d] focus:ring-2 focus:ring-emerald-500/20 focus:outline-none transition-all">
                                <button type="button"
                                        id="togglePasswordBtn"
                                        onclick="togglePasswordVisibility('password', 'togglePasswordIcon')"
                                        title="Tampilkan kata sandi"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                    <span id="togglePasswordIcon" class="material-symbols-outlined text-[18px]">visibility</span>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-[11px] text-rose-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Konfirmasi Kata Sandi -->
                        <div>
                            <label for="password_confirmation" class="block text-xs font-semibold text-[#121c2a] mb-1.5">
                                Ulangi Kata Sandi
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <span class="material-symbols-outlined text-[18px]">lock_reset</span>
                                </span>
                                <input type="password"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       required
                                       minlength="8"
                                       autocomplete="new-password"
                                       placeholder="Ulangi kata sandi"
                                       class="w-full pl-10 pr-10 py-2.5 rounded-xl bg-slate-50 border border-[#dee9fc] text-sm text-[#121c2a] placeholder:text-slate-400 focus:bg-white focus:border-[#15803d] focus:ring-2 focus:ring-emerald-500/20 focus:outline-none transition-all">
                                <button type="button"
                                        id="toggleConfirmBtn"
                                        onclick="togglePasswordVisibility('password_confirmation', 'toggleConfirmIcon')"
                                        title="Tampilkan konfirmasi kata sandi"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                    <span id="toggleConfirmIcon" class="material-symbols-outlined text-[18px]">visibility</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Petunjuk Keamanan Kata Sandi -->
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-center gap-2 text-[11px] text-[#475569]">
                        <span class="material-symbols-outlined text-[16px] text-emerald-700">shield</span>
                        <span>Kata sandi minimal 8 karakter. Token Sanctum akan otomatis dibuat untuk akun baru.</span>
                    </div>

                    <!-- Tombol Daftar Submit -->
                    <div class="pt-2">
                        <button type="submit"
                                id="submitBtn"
                                class="w-full min-h-[44px] px-5 py-3 rounded-xl bg-gradient-to-r from-[#15803d] to-[#00652c] hover:from-[#16a34a] hover:to-[#007b36] text-white font-semibold text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 active:scale-[0.99] focus:ring-2 focus:ring-emerald-500/40 focus:outline-none">
                            <span id="btnIcon" class="material-symbols-outlined text-[18px]">how_to_reg</span>
                            <span id="btnText">Daftar Akun Sekarang</span>
                        </button>
                    </div>
                </form>

                <!-- Tautan Kembali ke Login -->
                <div class="mt-6 pt-5 border-t border-[#f1f5f9] text-center">
                    <p class="text-xs text-[#475569]">
                        Sudah memiliki akun terdaftar?
                        <a href="{{ route('login') }}" class="font-bold text-[#00652c] hover:text-emerald-800 hover:underline ml-1">
                            Masuk ke Katalog
                        </a>
                    </p>
                </div>

            </div>

        </div>
    </main>

    <!-- Footer Bersih -->
    <footer class="w-full border-t border-[#e6eeff] bg-white py-4 text-center text-xs text-[#475569]">
        <div class="max-w-6xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-2">
            <span>Athenaeum Library System · Otomasi Katalog Buku</span>
            <span class="font-mono text-[11px]">Laravel {{ app()->version() }} · Sanctum Auth</span>
        </div>
    </footer>

    <!-- Script Interaktif -->
    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility';
            }
        }

        // Tampilkan indikator proses saat formulir dikirim
        document.getElementById('registerForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            const icon = document.getElementById('btnIcon');
            const text = document.getElementById('btnText');
            btn.disabled = true;
            btn.classList.add('opacity-80', 'cursor-not-allowed');
            icon.textContent = 'sync';
            icon.classList.add('animate-spin');
            text.textContent = 'Mendaftarkan akun...';
        });
    </script>
</body>
</html>
