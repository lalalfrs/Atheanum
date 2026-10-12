@extends('layouts.public')

@section('title', $event->title)

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    <!-- Back Button -->
    <div>
        <a href="{{ route('events.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-text-secondary hover:text-[#2373F4] transition-colors">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Kembali ke Agenda Acara</span>
        </a>
    </div>

    <!-- Event Detail Card -->
    <article class="bg-white p-6 sm:p-12 rounded-3xl border border-border-light shadow-xs space-y-8">
        <div class="space-y-4 border-b border-slate-100 pb-6">
            <div class="flex flex-wrap items-center gap-3">
                <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-800 font-bold text-xs uppercase tracking-wider flex items-center gap-1">
                    <span class="material-symbols-outlined text-[15px]">event</span>
                    <span>Agenda Literasi</span>
                </span>
                <span class="text-xs text-text-muted flex items-center gap-1">
                    <span class="material-symbols-outlined text-[15px]">location_on</span>
                    <span>{{ $event->location }}</span>
                </span>
            </div>

            <h1 class="text-2xl sm:text-4xl font-extrabold text-text-primary tracking-tight leading-snug">
                {{ $event->title }}
            </h1>

            <!-- Schedule Highlight Box -->
            <div class="bg-surface-grey/70 p-4 sm:p-5 rounded-2xl border border-border-light flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-forest text-white flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-[24px]">calendar_month</span>
                    </div>
                    <div>
                        <span class="text-[11px] text-text-muted block">Tanggal &amp; Waktu</span>
                        <strong class="text-sm sm:text-base text-text-primary">
                            {{ $event->starts_at->format('l, d F Y') }}
                        </strong>
                        <span class="text-xs text-text-secondary block">
                            Pukul {{ $event->starts_at->format('H:i') }} WIB @if($event->ends_at) s/d {{ $event->ends_at->format('H:i') }} WIB @endif
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <span class="px-3 py-1.5 rounded-xl bg-white border border-border-light text-xs font-semibold text-forest flex items-center gap-1.5 shadow-2xs">
                        <span class="material-symbols-outlined text-[16px] text-emerald-600">check_circle</span>
                        <span>Terbuka untuk Umum &amp; Mahasiswa</span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="space-y-3">
            <h2 class="text-lg font-bold text-text-primary">Deskripsi Acara</h2>
            <div class="prose max-w-none text-text-primary text-sm sm:text-base leading-relaxed space-y-4 whitespace-pre-line">
                {{ $event->description }}
            </div>
        </div>

        <!-- Librarian Controls -->
        @auth
            @if(auth()->user()->isLibrarian())
                <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs text-text-muted">Kelola acara sebagai pustakawan</span>
                    <form method="POST" action="{{ route('events.destroy', $event) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus agenda acara ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3.5 py-2 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 text-xs font-semibold flex items-center gap-1 transition-colors cursor-pointer">
                            <span class="material-symbols-outlined text-[16px]">delete</span>
                            <span>Hapus Acara</span>
                        </button>
                    </form>
                </div>
            @endif
        @endauth
    </article>

</div>
@endsection
