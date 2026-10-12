@extends('layouts.public')

@section('title', 'Jadwalkan Acara Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div>
        <a href="{{ route('events.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-text-secondary hover:text-[#2373F4] transition-colors">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Kembali ke Agenda Acara</span>
        </a>
    </div>

    <div class="bg-white p-6 sm:p-10 rounded-3xl border border-border-light shadow-xs space-y-6">
        <div class="border-b border-border-light pb-4">
            <h1 class="text-2xl font-extrabold text-text-primary">Jadwalkan Agenda / Acara Literasi Baru</h1>
            <p class="text-xs text-text-muted mt-1">Publikasikan jadwal bedah buku, workshop sitasi, atau pelatihan riset ke beranda.</p>
        </div>

        <form method="POST" action="{{ route('events.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-text-primary mb-1">Nama Acara</label>
                <input type="text"
                       name="title"
                       value="{{ old('title') }}"
                       required
                       placeholder="Misal: Workshop Sitasi Ilmiah & Manajemen Referensi Mendeley"
                       class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-border-light text-xs sm:text-sm focus:outline-none focus:bg-white focus:ring-2 focus:ring-[#2373F4]/20">
                @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-text-primary mb-1">Lokasi Gedung / Ruangan</label>
                <input type="text"
                       name="location"
                       value="{{ old('location') }}"
                       required
                       placeholder="Misal: Ruang Multimedia Lt. 2 Perpustakaan Utama"
                       class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-border-light text-xs sm:text-sm focus:outline-none focus:bg-white focus:ring-2 focus:ring-[#2373F4]/20">
                @error('location') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-text-primary mb-1">Waktu Mulai</label>
                    <input type="datetime-local"
                           name="starts_at"
                           value="{{ old('starts_at', now()->addDays(7)->setTime(9, 0)->format('Y-m-d\TH:i')) }}"
                           required
                           class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-border-light text-xs sm:text-sm focus:outline-none focus:bg-white">
                    @error('starts_at') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-text-primary mb-1">Waktu Selesai (Opsional)</label>
                    <input type="datetime-local"
                           name="ends_at"
                           value="{{ old('ends_at') }}"
                           class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-border-light text-xs sm:text-sm focus:outline-none focus:bg-white">
                    @error('ends_at') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-text-primary mb-1">Deskripsi Lengkap Acara</label>
                <textarea name="description"
                          rows="6"
                          required
                          placeholder="Jelaskan narasumber, target peserta, dan materi yang akan dibahas..."
                          class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-border-light text-xs sm:text-sm focus:outline-none focus:bg-white focus:ring-2 focus:ring-[#2373F4]/20 leading-relaxed">{{ old('description') }}</textarea>
                @error('description') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4 border-t border-border-light flex items-center justify-end gap-3">
                <a href="{{ route('events.index') }}" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-text-secondary hover:bg-surface-grey transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-forest hover:bg-forest-light text-white text-xs sm:text-sm font-semibold transition-colors flex items-center gap-1.5 cursor-pointer">
                    <span class="material-symbols-outlined text-[18px]">event_available</span>
                    <span>Simpan &amp; Publikasikan Acara</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
