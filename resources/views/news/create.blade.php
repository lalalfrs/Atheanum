@extends('layouts.public')

@section('title', 'Tulis Berita Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div>
        <a href="{{ route('news.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-text-secondary hover:text-[#2373F4] transition-colors">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Kembali ke Berita</span>
        </a>
    </div>

    <div class="bg-white p-6 sm:p-10 rounded-3xl border border-border-light shadow-xs space-y-6">
        <div class="border-b border-border-light pb-4">
            <h1 class="text-2xl font-extrabold text-text-primary">Tulis Berita / Pengumuman Baru</h1>
            <p class="text-xs text-text-muted mt-1">Publikasikan warta literasi atau agenda layanan perpustakaan ke beranda publik.</p>
        </div>

        <form method="POST" action="{{ route('news.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-text-primary mb-1">Judul Berita</label>
                <input type="text"
                       name="title"
                       value="{{ old('title') }}"
                       required
                       placeholder="Misal: Jam Operasional Khusus Selama Pekan Ujian Akhir Semester"
                       class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-border-light text-xs sm:text-sm focus:outline-none focus:bg-white focus:ring-2 focus:ring-[#2373F4]/20">
                @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-text-primary mb-1">Ringkasan / Excerpt</label>
                <textarea name="excerpt"
                          rows="2"
                          required
                          placeholder="Ringkasan singkat yang akan tampil di kartu beranda..."
                          class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-border-light text-xs sm:text-sm focus:outline-none focus:bg-white focus:ring-2 focus:ring-[#2373F4]/20">{{ old('excerpt') }}</textarea>
                @error('excerpt') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-text-primary mb-1">Isi Berita Lengkap</label>
                <textarea name="body"
                          rows="8"
                          required
                          placeholder="Tuliskan isi berita lengkap di sini..."
                          class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-border-light text-xs sm:text-sm focus:outline-none focus:bg-white focus:ring-2 focus:ring-[#2373F4]/20 leading-relaxed">{{ old('body') }}</textarea>
                @error('body') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-text-primary mb-1">Tanggal Terbit (Opsional)</label>
                <input type="datetime-local"
                       name="published_at"
                       value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}"
                       class="w-full sm:w-64 px-3.5 py-2.5 rounded-xl bg-slate-50 border border-border-light text-xs sm:text-sm focus:outline-none focus:bg-white">
                <span class="text-[11px] text-text-muted block mt-1">Kosongkan untuk otomatis menggunakan waktu saat ini.</span>
            </div>

            <div class="pt-4 border-t border-border-light flex items-center justify-end gap-3">
                <a href="{{ route('news.index') }}" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-text-secondary hover:bg-surface-grey transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#2373F4] hover:bg-[#1A5EC4] text-white text-xs sm:text-sm font-semibold transition-colors flex items-center gap-1.5 cursor-pointer">
                    <span class="material-symbols-outlined text-[18px]">publish</span>
                    <span>Terbitkan Berita</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
