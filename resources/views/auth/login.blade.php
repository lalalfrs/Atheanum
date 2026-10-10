<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk Sistem · Athenaeum Library System</title>

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
                <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-[#00652c] bg-[#eff4ff] hover:bg-[#dee9fc] transition-colors">
                    <span class="material-symbols-outlined text-[16px]">person_add</span>
                    <span>Daftar Akun Baru</span>
                </a>
                <a href="{{ route('welcome') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-[#475569] hover:text-[#121c2a] hover:bg-[#eff4ff] transition-colors">
                    <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                    <span class="hidden sm:inline">Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Konten Utama Halaman Login -->
    <main class="flex-1 flex items-center justify-center px-4 py-10 sm:py-14">
        <div class="w-full max-w-md">

            <!-- Card Utama Formulir Login -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-[#e6eeff]">
                
                <!-- Identitas & Judul Formulir -->
                <div class="mb-6 text-center">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#00652c] border border-emerald-100 flex items-center justify-center mx-auto mb-3 shadow-xs">
                        <span class="material-symbols-outlined text-[26px]">key</span>
                    </div>
                    <h1 class="font-headline font-bold text-2xl text-[#121c2a] tracking-tight">
                        Masuk ke Akun
                    </h1>
                    <p class="text-xs text-[#475569] mt-1.5 leading-relaxed">
                        Portal autentikasi untuk pustakawan, mahasiswa, dan seluruh anggota perpustakaan.
                    </p>
                </div>

                <!-- Notifikasi Flash Sukses -->
                @if(session('success'))
                <div class="mb-5 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl flex items-start gap-2.5 text-xs">
                    <span class="material-symbols-outlined text-emerald-700 text-[18px] shrink-0 mt-0.5">check_circle</span>
                    <div>
                        <strong class="font-semibold block">Informasi:</strong>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
                @endif

                <!-- Notifikasi Flash Kesalahan Validasi Global -->
                @if(session('error') || $errors->any())
                <div class="mb-5 p-3.5 bg-rose-50 border border-rose-200 text-rose-900 rounded-2xl flex items-start gap-2.5 text-xs">
                    <span class="material-symbols-outlined text-rose-700 text-[18px] shrink-0 mt-0.5">error</span>
                    <div>
                        <strong class="font-semibold block">Gagal Masuk:</strong>
                        <ul class="list-disc list-inside space-y-0.5 mt-0.5">
                            @if(session('error'))
                                <li>{{ session('error') }}</li>
                            @endif
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <!-- Form Login -->
                <form id="loginForm" method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <!-- Input Surel (Email) -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-[#121c2a] mb-1.5">
                            Alamat Surel Pengguna
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <span class="material-symbols-outlined text-[18px]">mail</span>
                            </span>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', 'librarian@athenaeum.test') }}"
                                   required
                                   autocomplete="email"
                                   autofocus
                                   placeholder="nama@athenaeum.test"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-50 border {{ $errors->has('email') ? 'border-rose-400 bg-rose-50/30' : 'border-[#dee9fc]' }} text-sm text-[#121c2a] placeholder:text-slate-400 focus:bg-white focus:border-[#15803d] focus:ring-2 focus:ring-emerald-500/20 focus:outline-none transition-all">
                        </div>
                        @error('email')
                            <p class="text-[11px] text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Kata Sandi (Password) -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-semibold text-[#121c2a]">
                                Kata Sandi
                            </label>
                            <span class="text-[11px] text-[#475569]">Standar demo: password</span>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <span class="material-symbols-outlined text-[18px]">lock</span>
                            </span>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   value="password"
                                   required
                                   autocomplete="current-password"
                                   placeholder="Masukkan kata sandi..."
                                   class="w-full pl-10 pr-11 py-2.5 rounded-xl bg-slate-50 border {{ $errors->has('password') ? 'border-rose-400 bg-rose-50/30' : 'border-[#dee9fc]' }} text-sm text-[#121c2a] placeholder:text-slate-400 focus:bg-white focus:border-[#15803d] focus:ring-2 focus:ring-emerald-500/20 focus:outline-none transition-all">
                            <button type="button"
                                    id="togglePasswordBtn"
                                    onclick="togglePasswordVisibility()"
                                    title="Tampilkan kata sandi"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                                <span id="togglePasswordIcon" class="material-symbols-outlined text-[18px]">visibility</span>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-[11px] text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Opsi Ingat Sesi & Quick Fill Demo -->
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox"
                                   id="remember"
                                   name="remember"
                                   value="1"
                                   {{ old('remember') ? 'checked' : '' }}
                                   class="w-4 h-4 text-emerald-700 bg-white border-[#dee9fc] rounded focus:ring-emerald-500 focus:ring-offset-0">
                            <span class="text-xs text-[#475569] font-medium">Ingat perangkat ini</span>
                        </label>

                        <div class="flex items-center gap-2 text-xs">
                            <button type="button"
                                    onclick="fillDemoCredentials('librarian@athenaeum.test')"
                                    class="font-semibold text-[#00652c] hover:text-emerald-800 hover:underline cursor-pointer">
                                Demo Pustakawan
                            </button>
                            <span class="text-slate-300">·</span>
                            <button type="button"
                                    onclick="fillDemoCredentials('mahasiswa@athenaeum.test')"
                                    class="font-semibold text-blue-700 hover:text-blue-900 hover:underline cursor-pointer">
                                Demo Anggota
                            </button>
                        </div>
                    </div>

                    <!-- Tombol Masuk Submit -->
                    <div class="pt-2">
                        <button type="submit"
                                id="submitBtn"
                                class="w-full min-h-[44px] px-5 py-3 rounded-xl bg-gradient-to-r from-[#15803d] to-[#00652c] hover:from-[#16a34a] hover:to-[#007b36] text-white font-semibold text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 active:scale-[0.99] focus:ring-2 focus:ring-emerald-500/40 focus:outline-none cursor-pointer">
                            <span id="btnIcon" class="material-symbols-outlined text-[18px]">login</span>
                            <span id="btnText">Masuk ke Sistem</span>
                        </button>
                    </div>

                    <!-- Tautan Pendaftaran Akun Baru -->
                    <div class="pt-2 text-center">
                        <p class="text-xs text-[#475569]">
                            Belum memiliki akun perpustakaan?
                            <a href="{{ route('register') }}" class="font-bold text-[#00652c] hover:text-emerald-800 hover:underline ml-1">
                                Daftar Akun Baru
                            </a>
                        </p>
                    </div>
                </form>

                <!-- Panel Informasi Arsitektur Laravel Sanctum -->
                <div class="mt-6 pt-5 border-t border-[#f1f5f9]">
                    <div class="rounded-2xl bg-emerald-50/70 border border-emerald-100 p-3.5 text-xs text-[#121c2a]">
                        <div class="flex items-center gap-1.5 font-bold text-[#00652c] mb-1">
                            <span class="material-symbols-outlined text-[16px]">verified_user</span>
                            <span>Mekanisme Laravel Sanctum</span>
                        </div>
                        <p class="text-[11px] text-[#475569] leading-relaxed">
                            Formulir ini memadukan autentikasi sesi SPA berbasis cookies serta penerbitan Personal Access Token untuk akses REST API terproteksi.
                        </p>
                    </div>
                </div>

            </div>

            <!-- Kartu Info Kredensial Bawaan -->
            <div class="mt-4 p-4 bg-white rounded-2xl border border-[#e6eeff] flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-[#475569]">
                <div>
                    <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Kredensial Bawaan Demo</span>
                    <div class="font-mono text-slate-700 font-medium text-[11px] mt-0.5 space-y-0.5">
                        <div>Pustakawan: <span class="text-[#00652c] font-bold">librarian@athenaeum.test</span></div>
                        <div>Anggota/Mahasiswa: <span class="text-blue-700 font-bold">mahasiswa@athenaeum.test</span></div>
                    </div>
                </div>
                <div class="flex items-center gap-1.5">
                    <button type="button"
                            onclick="fillDemoCredentials('librarian@athenaeum.test')"
                            class="px-2.5 py-1.5 bg-[#eff4ff] hover:bg-[#dee9fc] text-[#00652c] font-semibold rounded-lg text-xs transition-colors cursor-pointer">
                        Pustakawan
                    </button>
                    <button type="button"
                            onclick="fillDemoCredentials('mahasiswa@athenaeum.test')"
                            class="px-2.5 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-800 font-semibold rounded-lg text-xs transition-colors cursor-pointer">
                        Anggota
                    </button>
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
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                passwordInput.type = 'password';
                icon.textContent = 'visibility';
            }
        }

        function fillDemoCredentials(email = 'librarian@athenaeum.test') {
            document.getElementById('email').value = email;
            document.getElementById('password').value = 'password';
            document.getElementById('email').focus();
        }

        // Tampilkan indikator proses saat formulir dikirim
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            const icon = document.getElementById('btnIcon');
            const text = document.getElementById('btnText');
            btn.disabled = true;
            btn.classList.add('opacity-80', 'cursor-not-allowed');
            icon.textContent = 'sync';
            icon.classList.add('animate-spin');
            text.textContent = 'Memverifikasi kredensial...';
        });
    </script>
</body>
</html>
