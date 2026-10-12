@extends('layouts.public')

@section('title', 'Acara & Agenda Literasi')

@section('content')
<div class="space-y-8">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 sm:p-10 rounded-3xl border border-border-light shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                <span class="text-xs uppercase font-bold tracking-wider text-[#00652c]">Agenda Kegiatan</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-text-primary tracking-tight mt-1">
                Acara &amp; Workshop Literasi
            </h1>
            <p class="text-xs sm:text-sm text-text-secondary mt-1">
                Ikuti bedah buku, pelatihan manajemen referensi, workshop riset, dan kelas literasi informasi.
            </p>
        </div>

        @auth
            @if(auth()->user()->isLibrarian())
                <a href="{{ route('events.create') }}"
                   class="px-4 py-2.5 rounded-xl bg-forest hover:bg-forest-light text-white text-xs font-semibold shadow-xs flex items-center gap-1.5 shrink-0 transition-colors">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    <span>Jadwalkan Acara Baru</span>
                </a>
            @endif
        @endauth
    </div>

    <!-- Upcoming Events -->
    <div class="space-y-4">
        <h2 class="text-lg font-bold text-text-primary flex items-center gap-2">
            <span class="material-symbols-outlined text-emerald-600">event_upcoming</span>
            <span>Acara Mendatang</span>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($upcomingEvents as $evt)
                <article class="bg-white p-6 rounded-3xl border border-border-light shadow-xs hover:shadow-md transition-shadow flex flex-col justify-between group">
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="w-14 rounded-xl bg-forest text-white p-2 text-center shrink-0">
                                <span class="block text-[10px] uppercase font-bold text-emerald-300">{{ $evt->starts_at->format('M') }}</span>
                                <span class="block text-xl font-extrabold leading-none my-0.5">{{ $evt->starts_at->format('d') }}</span>
                                <span class="block text-[9px] text-emerald-200/80">{{ $evt->starts_at->format('Y') }}</span>
                            </div>
                            <div class="min-w-0">
                                <span class="text-[10px] font-bold text-emerald-700 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[13px]">pin_drop</span>
                                    <span class="truncate">{{ $evt->location }}</span>
                                </span>
                                <span class="text-[11px] text-text-muted block mt-0.5">
                                    {{ $evt->starts_at->format('H:i') }} WIB @if($evt->ends_at) - {{ $evt->ends_at->format('H:i') }} WIB @endif
                                </span>
                            </div>
                        </div>

                        <h3 class="font-bold text-base text-text-primary group-hover:text-[#2373F4] transition-colors line-clamp-2">
                            <a href="{{ route('events.show', $evt) }}">{{ $evt->title }}</a>
                        </h3>

                        <p class="text-xs text-text-secondary line-clamp-3 leading-relaxed">
                            {{ $evt->description }}
                        </p>
                    </div>

                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('events.show', $evt) }}" class="text-xs font-semibold text-[#2373F4] hover:underline flex items-center gap-1">
                            <span>Lihat Detail Event</span>
                            <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-full bg-white p-12 rounded-3xl border border-border-light text-center space-y-2">
                    <span class="material-symbols-outlined text-4xl text-slate-300">event_busy</span>
                    <p class="text-sm font-semibold text-text-primary">Belum ada agenda acara mendatang.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Past Events (if any) -->
    @if($pastEvents->isNotEmpty())
        <div class="space-y-4 pt-8">
            <h2 class="text-lg font-bold text-text-muted flex items-center gap-2">
                <span class="material-symbols-outlined text-slate-400">history</span>
                <span>Acara yang Telah Berlangsung</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($pastEvents as $past)
                    <div class="bg-white/80 p-4 rounded-2xl border border-border-light space-y-1">
                        <span class="text-[10px] text-text-muted">{{ $past->starts_at->format('d M Y') }} &bull; {{ $past->location }}</span>
                        <h4 class="font-bold text-xs sm:text-sm text-text-primary line-clamp-1">{{ $past->title }}</h4>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
