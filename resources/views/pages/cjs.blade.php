@extends('layouts.public')

@section('title', 'CJS per Prodi')

@section('content')
<div class="space-y-12">

    <!-- Header Section -->
    <div class="bg-white p-6 sm:p-10 rounded-3xl border border-border-light shadow-xs space-y-3">
        <div class="flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
            <span class="text-xs uppercase font-bold tracking-wider text-amber-700">Publikasi Riset &amp; Jurnal</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-text-primary tracking-tight">
            Pemilihan CJS per Program Studi
        </h1>
        <p class="text-sm text-text-secondary max-w-2xl leading-relaxed">
            Akses langsung ke portal <em>Cambridge / Journal System (CJS)</em> dan repositori publikasi karya ilmiah yang dispesifikasi berdasarkan masing-masing fakultas dan program studi.
        </p>
    </div>

    <!-- Filter & Grid Prodi -->
    @php
        $defaultProdi = [
            ['name' => 'S1 Teknik Informatika', 'faculty' => 'Fakultas Ilmu Komputer & Teknologi', 'code' => 'TI', 'color' => 'bg-[#2373F4]', 'desc' => 'Jurnal kecerdasan buatan, rekayasa perangkat lunak, komputasi awan, dan data sains.'],
            ['name' => 'S1 Sistem Informasi', 'faculty' => 'Fakultas Ilmu Komputer & Teknologi', 'code' => 'SI', 'color' => 'bg-indigo-600', 'desc' => 'Publikasi tata kelola TI, sistem enterprise, analitik bisnis, dan manajemen pengetahuan.'],
            ['name' => 'S1 Manajemen Bisnis', 'faculty' => 'Fakultas Ekonomi & Bisnis', 'code' => 'MB', 'color' => 'bg-emerald-600', 'desc' => 'Riset manajemen strategis, pemasaran digital, keuangan korporat, dan kewirausahaan.'],
            ['name' => 'S1 Akuntansi', 'faculty' => 'Fakultas Ekonomi & Bisnis', 'code' => 'AKT', 'color' => 'bg-teal-600', 'desc' => 'Jurnal audit forensik, akuntansi sektor publik, perpajakan, dan pelaporan keuangan.'],
            ['name' => 'S1 Ilmu Komunikasi', 'faculty' => 'Fakultas Ilmu Sosial & Humaniora', 'code' => 'IK', 'color' => 'bg-amber-600', 'desc' => 'Kajian media baru, komunikasi publik, jurnalisme investigatif, dan periklanan kreatif.'],
            ['name' => 'S1 Desain Komunikasi Visual', 'faculty' => 'Fakultas Desain & Seni Kreatif', 'code' => 'DKV', 'color' => 'bg-rose-600', 'desc' => 'Arsip karya visual, animasi interaktif, tipografi eksperimental, dan media imersif.'],
            ['name' => 'S1 Hukum Bisnis', 'faculty' => 'Fakultas Hukum', 'code' => 'HK', 'color' => 'bg-slate-700', 'desc' => 'Kajian hukum siber, kekayaan intelektual, kepatuhan korporasi, dan hukum perdata internasional.'],
            ['name' => 'S1 Teknik Industri', 'faculty' => 'Fakultas Teknik & Rekayasa', 'code' => 'TIN', 'color' => 'bg-orange-600', 'desc' => 'Riset rantai pasok cerdas, ergonomi industri, optimasi sistem produksi, dan manufaktur lanjut.'],
        ];
        $prodiList = !empty($programs) ? $programs : $defaultProdi;
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($prodiList as $p)
            <div class="bg-white p-6 rounded-3xl border border-border-light shadow-xs hover:shadow-md hover:border-[#2373F4]/40 transition-all flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl {{ $p['color'] ?? 'bg-[#2373F4]' }} text-white flex items-center justify-center font-bold text-sm shadow-xs">
                            {{ $p['code'] ?? strtoupper(substr($p['name'], 0, 2)) }}
                        </div>
                        <span class="text-[10px] font-bold text-text-muted uppercase tracking-wider bg-surface-grey px-2 py-0.5 rounded-full">
                            Akreditasi Sinta
                        </span>
                    </div>

                    <span class="text-[10px] font-bold uppercase tracking-wider text-text-muted block mb-1">
                        {{ $p['faculty'] ?? 'Program Studi' }}
                    </span>
                    <h3 class="font-bold text-base text-text-primary group-hover:text-[#2373F4] transition-colors">
                        {{ $p['name'] }}
                    </h3>
                    <p class="text-xs text-text-secondary mt-2 leading-relaxed">
                        {{ $p['desc'] ?? 'Publikasi artikel ilmiah dan jurnal hasil riset program studi.' }}
                    </p>
                </div>

                <div class="pt-4 mt-4 border-t border-slate-100">
                    @if(!empty($p['url']))
                        <a href="{{ $p['url'] }}" target="_blank" rel="noopener noreferrer"
                           class="w-full py-2 px-3 rounded-xl bg-surface-grey hover:bg-[#2373F4] hover:text-white text-text-primary text-xs font-semibold flex items-center justify-center gap-1.5 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                            <span>Buka Portal CJS</span>
                        </a>
                    @else
                        <a href="{{ route('books.index', ['search' => $p['name']]) }}"
                           class="w-full py-2 px-3 rounded-xl bg-surface-grey hover:bg-[#2373F4] hover:text-white text-text-primary text-xs font-semibold flex items-center justify-center gap-1.5 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">menu_book</span>
                            <span>Lihat Terbitan &amp; Jurnal</span>
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
