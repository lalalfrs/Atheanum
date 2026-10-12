@extends('layouts.public')

@section('title', 'Pustakawan')

@section('content')
<div class="space-y-12">

    <!-- Header Section -->
    <div class="bg-white p-6 sm:p-10 rounded-3xl border border-border-light shadow-xs space-y-3">
        <div class="flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
            <span class="text-xs uppercase font-bold tracking-wider text-[#00652c]">Profil Staf</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-text-primary tracking-tight">
            Direktori Pustakawan &amp; Pengelola
        </h1>
        <p class="text-sm text-text-secondary max-w-2xl leading-relaxed">
            Tim pustakawan profesional kami berdedikasi melayani sirkulasi katalog, preservasi literatur ilmiah, literasi informasi, dan asistensi riset mahasiswa.
        </p>
    </div>

    <!-- Librarians Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($librarians as $staff)
            <div class="bg-white p-6 rounded-3xl border border-border-light shadow-xs hover:shadow-md transition-shadow flex flex-col justify-between group">
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl {{ $staff->isSuperAdmin() ? 'bg-[#2373F4]' : 'bg-forest' }} text-white flex items-center justify-center font-bold text-lg shadow-xs">
                            {{ strtoupper(substr($staff->name, 0, 2)) }}
                        </div>
                        <div>
                            <h2 class="font-bold text-base text-text-primary group-hover:text-[#2373F4] transition-colors">
                                {{ $staff->name }}
                            </h2>
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-0.5 rounded-md mt-1 {{ $staff->isSuperAdmin() ? 'bg-[#2373F4]/10 text-[#2373F4]' : 'bg-emerald-50 text-emerald-800' }}">
                                <span class="material-symbols-outlined text-[13px]">{{ $staff->isSuperAdmin() ? 'admin_panel_settings' : 'badge' }}</span>
                                <span>{{ $staff->isSuperAdmin() ? 'Kepala Perpustakaan / Super Admin' : 'Pustakawan Sirkulasi' }}</span>
                            </span>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 space-y-2 text-xs text-text-secondary">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[16px] text-text-muted">mail</span>
                            <span class="font-mono text-[11px] truncate">{{ $staff->email }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[16px] text-text-muted">workspace_premium</span>
                            <span>Layanan Sirkulasi &amp; Katalogisasi OPAC</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[11px] text-emerald-700 font-semibold flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>Staf Aktif</span>
                    </span>
                    <a href="mailto:{{ $staff->email }}" class="text-xs font-semibold text-[#2373F4] hover:underline flex items-center gap-1">
                        <span>Hubungi</span>
                        <span class="material-symbols-outlined text-[14px]">send</span>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white p-12 rounded-3xl border border-border-light text-center space-y-2">
                <span class="material-symbols-outlined text-4xl text-slate-300">badge</span>
                <p class="text-sm font-semibold text-text-primary">Belum ada akun pustakawan terdaftar.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection
