@extends('layouts.app')

@section('title', 'Pengaturan & Diagnostik Sistem - Athenaeum')
@section('page_category', 'Pengaturan Sistem')

@section('content')
<div class="flex flex-col w-full space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-1 text-[#6f7a6e] text-[11px] uppercase tracking-wider font-bold">
                <span>Konfigurasi</span>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-[#00652c]">Pengaturan &amp; Status Server</span>
            </div>
            <h1 class="font-headline text-3xl font-bold text-[#121c2a] tracking-tight">
                Pengaturan &amp; Diagnostik
            </h1>
            <p class="text-xs text-[#6f7a6e]">
                Informasi status server aplikasi, konfigurasi database storage, dan opsi pemeliharaan katalog.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-[#eff4ff] text-[#00652c] border border-[#dee9fc] flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Sistem Operasional Normal</span>
            </span>
        </div>
    </div>

    <!-- Diagnostic Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-2xl shadow-xs border border-[#e6eeff]">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-[#6f7a6e] uppercase">Runtime PHP</span>
                <span class="material-symbols-outlined text-[#15803d] text-[20px]">terminal</span>
            </div>
            <div class="font-headline text-2xl font-bold text-[#121c2a]">
                v{{ $systemInfo['php_version'] }}
            </div>
            <p class="text-[11px] text-[#6f7a6e] mt-1">PHP CLI / Built-in Web Server</p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-xs border border-[#e6eeff]">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-[#6f7a6e] uppercase">Framework</span>
                <span class="material-symbols-outlined text-[#15803d] text-[20px]">layers</span>
            </div>
            <div class="font-headline text-2xl font-bold text-[#121c2a]">
                Laravel {{ $systemInfo['laravel_version'] }}
            </div>
            <p class="text-[11px] text-[#6f7a6e] mt-1">Mode: {{ strtoupper($systemInfo['environment']) }}</p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-xs border border-[#e6eeff]">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-[#6f7a6e] uppercase">Database Engine</span>
                <span class="material-symbols-outlined text-[#15803d] text-[20px]">database</span>
            </div>
            <div class="font-headline text-2xl font-bold text-[#121c2a]">
                {{ strtoupper($systemInfo['database_driver']) }}
            </div>
            <p class="text-[11px] text-[#6f7a6e] mt-1">{{ $systemInfo['total_books'] }} buku, {{ $systemInfo['total_categories'] }} kategori</p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-xs border border-[#e6eeff]">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-[#6f7a6e] uppercase">Storage Symlink</span>
                <span class="material-symbols-outlined {{ $systemInfo['storage_linked'] ? 'text-[#15803d]' : 'text-amber-500' }} text-[20px]">
                    {{ $systemInfo['storage_linked'] ? 'check_circle' : 'warning' }}
                </span>
            </div>
            <div class="font-headline text-2xl font-bold text-[#121c2a]">
                {{ $systemInfo['storage_linked'] ? 'Terhubung' : 'Belum Ada' }}
            </div>
            <p class="text-[11px] text-[#6f7a6e] mt-1">public/storage symlink</p>
        </div>
    </div>

    <!-- System Configuration Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Configuration Table -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-xs border border-[#e6eeff] p-6">
            <h2 class="font-headline font-bold text-lg text-[#121c2a] mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-[#15803d]">tune</span>
                <span>Parameter Konfigurasi Server</span>
            </h2>

            <div class="divide-y divide-[#f1f5f9] text-xs">
                <div class="py-3 flex items-center justify-between">
                    <span class="text-[#6f7a6e]">Nama Aplikasi (APP_NAME)</span>
                    <span class="font-semibold text-[#121c2a]">{{ config('app.name') }}</span>
                </div>
                <div class="py-3 flex items-center justify-between">
                    <span class="text-[#6f7a6e]">Environment (APP_ENV)</span>
                    <span class="px-2 py-0.5 rounded font-mono font-bold bg-[#eff4ff] text-[#00652c]">{{ config('app.env') }}</span>
                </div>
                <div class="py-3 flex items-center justify-between">
                    <span class="text-[#6f7a6e]">Mode Debug (APP_DEBUG)</span>
                    <span class="px-2 py-0.5 rounded font-mono font-bold {{ config('app.debug') ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                        {{ config('app.debug') ? 'ENABLED (Aktif)' : 'DISABLED' }}
                    </span>
                </div>
                <div class="py-3 flex items-center justify-between">
                    <span class="text-[#6f7a6e]">URL Dasar (APP_URL)</span>
                    <span class="font-mono text-[#121c2a]">{{ config('app.url') }}</span>
                </div>
                <div class="py-3 flex items-center justify-between">
                    <span class="text-[#6f7a6e]">Driver Database Default</span>
                    <span class="font-mono font-semibold text-[#00652c]">{{ config('database.default') }}</span>
                </div>
                <div class="py-3 flex items-center justify-between">
                    <span class="text-[#6f7a6e]">Driver Cache &amp; Session</span>
                    <span class="font-mono text-[#121c2a]">{{ config('cache.default') }} / {{ config('session.driver') }}</span>
                </div>
                <div class="py-3 flex items-center justify-between">
                    <span class="text-[#6f7a6e]">Filesystem Disk</span>
                    <span class="font-mono text-[#121c2a]">{{ config('filesystems.default') }} (storage/app/public)</span>
                </div>
            </div>
        </div>

        <!-- Maintenance & Data Actions -->
        <div class="bg-white rounded-2xl shadow-xs border border-[#e6eeff] p-6 flex flex-col justify-between">
            <div>
                <h2 class="font-headline font-bold text-lg text-[#121c2a] mb-2 flex items-center gap-2">
                    <span class="material-symbols-outlined text-rose-600">restart_alt</span>
                    <span>Pemeliharaan Database</span>
                </h2>
                <p class="text-xs text-[#6f7a6e] mb-4 leading-relaxed">
                    Kembalikan seluruh isi database ke seed awal katalog bawaan (semua penambahan data buku atau modifikasi akan direset).
                </p>

                <div class="p-3.5 bg-rose-50 border border-rose-200 rounded-xl mb-6 text-xs text-rose-800">
                    <div class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-[18px] text-rose-600 flex-shrink-0 mt-0.5">warning</span>
                        <span>Perhatian: Perintah <code class="font-mono bg-rose-100 px-1 py-0.5 rounded">migrate:fresh --seed</code> akan menghapus semua tabel dan mengisi ulang data katalog default.</span>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('settings.reset') }}" onsubmit="return confirm('Apakah Anda yakin ingin mereset seluruh database katalog ke data awal? Tindakan ini tidak dapat dibatalkan.')">
                @csrf
                <button type="submit"
                        class="w-full py-2.5 px-4 rounded-xl text-xs font-semibold bg-rose-600 hover:bg-rose-700 text-white shadow-xs transition-colors flex items-center justify-center gap-2 cursor-pointer">
                    <span class="material-symbols-outlined text-[18px]">restore</span>
                    <span>Reset Database ke Data Awal</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
