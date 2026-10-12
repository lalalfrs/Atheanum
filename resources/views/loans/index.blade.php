@extends('layouts.app')

@section('title', 'Layanan Peminjaman Buku · Athenaeum Library')
@section('page_category', $isStaff ? 'Sirkulasi & Peminjaman' : 'Peminjaman Saya')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-[#e6eeff] shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                <span class="text-xs uppercase font-bold tracking-wider text-[#00652c]">
                    {{ $isStaff ? 'Administrasi Sirkulasi' : 'Peminjaman Anggota' }}
                </span>
            </div>
            <h1 class="font-headline font-bold text-2xl text-[#121c2a] mt-1">
                {{ $isStaff ? 'Daftar Seluruh Peminjaman Buku' : 'Buku Pinjaman Saya' }}
            </h1>
            <p class="text-xs text-[#6f7a6e] mt-1">
                {{ $isStaff ? 'Pantau peredaran koleksi fisik dan batas waktu pengembalian buku.' : 'Kelola buku katalog yang sedang Anda pinjam beserta tenggat pengembalian.' }}
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('books.index') }}"
               class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-[#15803d] to-[#00652c] text-white text-xs font-semibold shadow-sm hover:shadow hover:from-[#16a34a] hover:to-[#007b36] transition-all flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                <span>Pinjam Buku Baru</span>
            </a>
        </div>
    </div>

    <!-- Ringkasan Statistik Sirkulasi -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-[#e6eeff] shadow-xs flex items-center gap-3 sm:gap-4">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[20px] sm:text-[24px]">book</span>
            </div>
            <div>
                <span class="text-[10px] sm:text-[11px] font-bold text-[#6f7a6e] uppercase tracking-wider block">Dipinjam</span>
                <span class="font-headline font-extrabold text-xl sm:text-2xl text-[#121c2a]">{{ $stats['active'] }}</span>
            </div>
        </div>

        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-[#e6eeff] shadow-xs flex items-center gap-3 sm:gap-4">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[20px] sm:text-[24px]">warning</span>
            </div>
            <div>
                <span class="text-[10px] sm:text-[11px] font-bold text-rose-500 uppercase tracking-wider block">Terlambat</span>
                <span class="font-headline font-extrabold text-xl sm:text-2xl text-rose-600">{{ $stats['overdue'] }}</span>
            </div>
        </div>

        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-[#e6eeff] shadow-xs flex items-center gap-3 sm:gap-4">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-50 text-[#00652c] flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[20px] sm:text-[24px]">assignment_turned_in</span>
            </div>
            <div>
                <span class="text-[10px] sm:text-[11px] font-bold text-[#6f7a6e] uppercase tracking-wider block">Dikembalikan</span>
                <span class="font-headline font-extrabold text-xl sm:text-2xl text-[#121c2a]">{{ $stats['returned'] }}</span>
            </div>
        </div>

        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-[#e6eeff] shadow-xs flex items-center gap-3 sm:gap-4">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-[#2373F4]/10 text-[#2373F4] flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[20px] sm:text-[24px]">payments</span>
            </div>
            <div>
                <span class="text-[10px] sm:text-[11px] font-bold text-[#6f7a6e] uppercase tracking-wider block">Tunggakan Denda</span>
                <span class="font-headline font-extrabold text-base sm:text-xl text-[#121c2a]">Rp {{ number_format($stats['unpaid_fines'], 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Filter & Pencarian -->
    <div class="bg-white p-4 rounded-2xl border border-[#e6eeff] flex flex-col md:flex-row items-center justify-between gap-3 shadow-xs">
        <form method="GET" action="{{ route('loans.index') }}" class="w-full flex flex-col sm:flex-row items-center gap-2.5">
            <div class="relative flex-1 w-full">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <span class="material-symbols-outlined text-[18px]">search</span>
                </span>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari judul buku atau ISBN pinjaman..."
                       class="w-full pl-9 pr-3 py-2 rounded-xl bg-slate-50 border border-[#dee9fc] text-xs text-[#121c2a] focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
            </div>

            <select name="status"
                    onchange="this.form.submit()"
                    class="w-full sm:w-48 px-3 py-2 rounded-xl bg-slate-50 border border-[#dee9fc] text-xs text-[#121c2a] focus:bg-white focus:outline-none">
                <option value="">Semua Status</option>
                <option value="dipinjam" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Sedang Dipinjam</option>
                <option value="terlambat" {{ request('status') === 'terlambat' ? 'selected' : '' }}>Terlambat (Overdue)</option>
                <option value="denda" {{ request('status') === 'denda' ? 'selected' : '' }}>Tunggakan Denda</option>
                <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Sudah Dikembalikan</option>
            </select>

            <button type="submit"
                    class="px-4 py-2 rounded-xl bg-[#15803d] text-white text-xs font-semibold hover:bg-[#16a34a] transition-colors flex items-center gap-1.5 shrink-0 cursor-pointer">
                <span class="material-symbols-outlined text-[16px]">filter_alt</span>
                <span>Filter</span>
            </button>

            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('loans.index') }}"
                   class="px-3 py-2 rounded-xl bg-slate-100 text-[#6f7a6e] hover:text-[#121c2a] text-xs font-semibold transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Tabel Catatan Peminjaman -->
    <div class="bg-white rounded-2xl border border-[#e6eeff] overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#f8f9ff] border-b border-[#e6eeff] text-[#6f7a6e] uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="py-3.5 px-4">Buku Katalog</th>
                        @if($isStaff)
                        <th class="py-3.5 px-4">Peminjam</th>
                        @endif
                        <th class="py-3.5 px-4">Tanggal Pinjam</th>
                        <th class="py-3.5 px-4">Jatuh Tempo</th>
                        <th class="py-3.5 px-4">Denda Keterlambatan</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-right">Aksi &amp; Layanan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f1f5f9]">
                    @forelse($loans as $loan)
                    <tr class="hover:bg-[#fbfcfe] transition-colors">
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $loan->book->cover_url }}"
                                     alt="{{ $loan->book->title }}"
                                     class="w-10 h-14 object-cover rounded-lg shadow-xs border border-gray-100 shrink-0">
                                <div>
                                    <span class="font-semibold text-sm text-[#121c2a] block line-clamp-1">{{ $loan->book->title }}</span>
                                    <span class="text-[11px] text-[#6f7a6e] block">{{ $loan->book->author }} · {{ $loan->book->shelf_location }}</span>
                                    <span class="text-[10px] text-slate-400 font-mono">{{ $loan->book->isbn }}</span>
                                </div>
                            </div>
                        </td>

                        @if($isStaff)
                        <td class="py-3.5 px-4">
                            <span class="font-semibold text-[#121c2a] block">{{ $loan->user->name }}</span>
                            <span class="text-[11px] text-[#6f7a6e] font-mono">{{ $loan->user->email }}</span>
                        </td>
                        @endif

                        <td class="py-3.5 px-4 text-slate-600">
                            {{ $loan->borrowed_at ? $loan->borrowed_at->format('d M Y') : '-' }}
                        </td>

                        <td class="py-3.5 px-4">
                            @if($loan->status === 'dipinjam')
                                @php
                                    $isOverdue = $loan->isOverdue();
                                @endphp
                                <span class="font-semibold {{ $isOverdue ? 'text-rose-600' : 'text-slate-700' }} block">
                                    {{ $loan->due_date ? $loan->due_date->format('d M Y') : '-' }}
                                </span>
                                @if($isOverdue)
                                    <span class="text-[10px] text-rose-500 font-bold block">
                                        Terlambat {{ $loan->overdue_days }} hari
                                    </span>
                                @else
                                    <span class="text-[10px] text-slate-400 block">
                                        Sisa {{ max(0, (int) now()->startOfDay()->diffInDays($loan->due_date->startOfDay(), false)) }} hari
                                    </span>
                                @endif
                                @if($loan->renewed_count > 0)
                                    <span class="text-[9px] font-mono text-[#2373F4] bg-[#2373F4]/10 px-1 py-0.5 rounded mt-0.5 inline-block">
                                        Diperpanjang {{ $loan->renewed_count }}x
                                    </span>
                                @endif
                            @else
                                <span class="text-slate-500 block">
                                    Kembali: {{ $loan->returned_at ? $loan->returned_at->format('d M Y') : '-' }}
                                </span>
                                @if($loan->isOverdue())
                                    <span class="text-[10px] text-rose-500 font-medium block">
                                        Terlambat {{ $loan->overdue_days }} hari
                                    </span>
                                @endif
                            @endif
                        </td>

                        <td class="py-3.5 px-4">
                            @if($loan->fine_amount > 0)
                                <span class="font-bold text-xs text-[#121c2a] block">
                                    Rp {{ number_format($loan->fine_amount, 0, ',', '.') }}
                                </span>
                                @if($loan->fine_paid)
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-green-100 text-green-700 border border-green-200 inline-block mt-0.5">
                                        Lunas
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-rose-100 text-rose-700 border border-rose-200 inline-block mt-0.5">
                                        Belum Lunas
                                    </span>
                                @endif
                            @elseif($loan->status === 'dipinjam' && $loan->isOverdue())
                                <span class="font-bold text-xs text-rose-600 block">
                                    Rp {{ number_format($loan->current_fine, 0, ',', '.') }}
                                </span>
                                <span class="text-[9px] text-amber-600 font-semibold block">
                                    Berjalan (Rp1.000/hari)
                                </span>
                            @else
                                <span class="text-slate-400 font-mono">-</span>
                            @endif
                        </td>

                        <td class="py-3.5 px-4">
                            @if($loan->status === 'dipinjam')
                                @if($loan->isOverdue())
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800 border border-rose-200 inline-flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        <span>Terlambat</span>
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200 inline-flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        <span>Dipinjam</span>
                                    </span>
                                @endif
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-[#00652c] border border-emerald-200 inline-flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[13px]">check</span>
                                    <span>Selesai</span>
                                </span>
                            @endif
                        </td>

                        <td class="py-3.5 px-4 text-right">
                            <div class="flex items-center justify-end gap-1.5 flex-wrap">
                                @if($loan->status === 'dipinjam')
                                    <!-- Tombol Kembalikan Buku -->
                                    <form method="POST" action="{{ route('loans.return', $loan) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="px-2.5 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-[#00652c] text-xs font-semibold border border-emerald-200 transition-colors inline-flex items-center gap-1 cursor-pointer"
                                                title="Kembalikan Buku Fisik">
                                            <span class="material-symbols-outlined text-[15px]">keyboard_return</span>
                                            <span>Kembalikan</span>
                                        </button>
                                    </form>

                                    <!-- Tombol Perpanjang Masa Pinjam -->
                                    @if(! $loan->isOverdue() && $loan->renewed_count < 1)
                                        <form method="POST" action="{{ route('loans.renew', $loan) }}" class="inline">
                                            @csrf
                                            <button type="submit"
                                                    class="px-2.5 py-1.5 rounded-lg bg-[#2373F4]/10 hover:bg-[#2373F4]/20 text-[#2373F4] text-xs font-semibold border border-[#2373F4]/20 transition-colors inline-flex items-center gap-1 cursor-pointer"
                                                    title="Perpanjang 7 Hari (Maksimal 1 kali)">
                                                <span class="material-symbols-outlined text-[15px]">update</span>
                                                <span>+7 Hari</span>
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <!-- Status Denda & Tombol Pelunasan -->
                                    @if($loan->fine_amount > 0 && ! $loan->fine_paid)
                                        @if($isStaff)
                                            <form method="POST" action="{{ route('loans.payFine', $loan) }}" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        class="px-2.5 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-semibold border border-rose-200 transition-colors inline-flex items-center gap-1 cursor-pointer"
                                                        title="Catat Pembayaran Denda Lunas">
                                                    <span class="material-symbols-outlined text-[15px]">price_check</span>
                                                    <span>Lunasi Denda</span>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-[11px] text-rose-600 font-bold block">
                                                Bayar di Pustakawan
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-xs text-slate-400 italic">Selesai</span>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $isStaff ? 7 : 6 }}" class="py-12 text-center text-slate-400">
                            <span class="material-symbols-outlined text-4xl mb-2 block text-slate-300">import_contacts</span>
                            <span class="font-semibold text-sm text-slate-600 block">Belum ada riwayat peminjaman buku</span>
                            <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                                Telusuri katalog buku untuk meminjam eksemplar fisik yang tersedia di rak perpustakaan.
                            </p>
                            <a href="{{ route('books.index') }}"
                               class="inline-flex items-center gap-1.5 px-4 py-2 mt-4 rounded-xl bg-[#15803d] text-white text-xs font-semibold hover:bg-[#16a34a] transition-colors">
                                <span class="material-symbols-outlined text-[16px]">menu_book</span>
                                <span>Buka Katalog Buku</span>
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($loans->hasPages())
        <div class="p-4 border-t border-[#e6eeff] bg-[#f8f9ff]">
            {{ $loans->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
