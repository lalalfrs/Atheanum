@extends('layouts.public')

@section('title', 'Tentang Kami')

@section('content')
<div class="space-y-12">

    <!-- Header Section -->
    <div class="bg-white p-6 sm:p-10 rounded-3xl border border-border-light shadow-xs space-y-3">
        <div class="flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-[#2373F4]"></span>
            <span class="text-xs uppercase font-bold tracking-wider text-[#2373F4]">Profil &amp; Informasi</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-text-primary tracking-tight">
            Tentang {{ config('library.name', 'Athenaeum Library') }}
        </h1>
        <p class="text-sm text-text-secondary max-w-2xl leading-relaxed">
            Menjadi pusat keunggulan literasi, repositori riset ilmiah, dan ruang belajar terbuka yang adaptif terhadap era digital bagi seluruh civitas akademika dan masyarakat luas.
        </p>
    </div>

    <!-- Visi, Misi & Nilai Utama -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-border-light shadow-xs space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-forest text-white flex items-center justify-center font-bold">
                <span class="material-symbols-outlined text-[24px]">visibility</span>
            </div>
            <h2 class="text-xl font-bold text-text-primary">Visi Perpustakaan</h2>
            <p class="text-xs sm:text-sm text-text-secondary leading-relaxed">
                Mewujudkan perpustakaan rujukan berbasis teknologi mutakhir yang inklusif, menyediakan akses literasi ilmiah global, serta menumbuhkan ekosistem penelitian yang berintegritas tinggi.
            </p>
        </div>

        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-border-light shadow-xs space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-[#2373F4] text-white flex items-center justify-center font-bold">
                <span class="material-symbols-outlined text-[24px]">flag</span>
            </div>
            <h2 class="text-xl font-bold text-text-primary">Misi Utama</h2>
            <ul class="space-y-2.5 text-xs sm:text-sm text-text-secondary leading-relaxed">
                <li class="flex items-start gap-2">
                    <span class="material-symbols-outlined text-[18px] text-emerald-600 shrink-0">check_circle</span>
                    <span>Mengelola koleksi fisik dan digital yang relevan, mutakhir, dan berstandar internasional.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="material-symbols-outlined text-[18px] text-emerald-600 shrink-0">check_circle</span>
                    <span>Menyediakan layanan OPAC sirkulasi mandiri yang cepat, transparan, dan akuntabel.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="material-symbols-outlined text-[18px] text-emerald-600 shrink-0">check_circle</span>
                    <span>Menjaga pelestarian karya ilmiah sivitas akademika lewat repositori dan portal e-journal.</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Kebijakan Sirkulasi Resmi -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-border-light shadow-xs space-y-6">
        <div class="border-b border-border-light pb-4">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px] text-amber-600">policy</span>
                <h2 class="text-xl font-bold text-text-primary">Kebijakan Sirkulasi &amp; Peminjaman Resmi</h2>
            </div>
            <p class="text-xs text-text-muted mt-1">
                Aturan standar sirkulasi perpustakaan yang berlaku bagi seluruh anggota aktif.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="p-4 rounded-2xl bg-surface-grey/60 border border-border-light space-y-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-text-muted">Masa Pinjam Standar</span>
                <p class="text-xl font-extrabold text-forest">{{ $policy['duration'] }} Hari</p>
                <span class="text-xs text-text-secondary">Dapat diperpanjang sebelum jatuh tempo.</span>
            </div>

            <div class="p-4 rounded-2xl bg-surface-grey/60 border border-border-light space-y-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-text-muted">Batas Kuota Pinjam</span>
                <p class="text-xl font-extrabold text-forest">{{ $policy['max_loans'] }} Buku</p>
                <span class="text-xs text-text-secondary">Maksimal peminjaman aktif bersamaan per anggota.</span>
            </div>

            <div class="p-4 rounded-2xl bg-surface-grey/60 border border-border-light space-y-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-text-muted">Perpanjangan Mandiri</span>
                <p class="text-xl font-extrabold text-[#2373F4]">+{{ $policy['renewal_days'] }} Hari</p>
                <span class="text-xs text-text-secondary">Maksimal {{ $policy['max_renewals'] }}x perpanjangan jika belum terlambat.</span>
            </div>

            <div class="p-4 rounded-2xl bg-surface-grey/60 border border-border-light space-y-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-text-muted">Denda Keterlambatan</span>
                <p class="text-xl font-extrabold text-rose-600">Rp {{ number_format($policy['fine'], 0, ',', '.') }}/hari</p>
                <span class="text-xs text-text-secondary">Per buku per hari keterlambatan pengembalian.</span>
            </div>
        </div>
    </div>

</div>
@endsection
