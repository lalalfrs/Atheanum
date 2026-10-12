@extends('layouts.app')

@section('title', 'Manajemen Pengguna & Peran · Athenaeum Library')
@section('page_category', 'Administrasi Super Admin')

@section('content')
<div class="space-y-6">

    <!-- Header & Ringkasan Peran -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-[#e6eeff] shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                <span class="text-xs uppercase font-bold tracking-wider text-[#00652c]">Hak Akses &amp; Otoritas</span>
            </div>
            <h1 class="font-headline font-bold text-2xl text-[#121c2a] mt-1">
                Manajemen Pengguna &amp; Promosi Peran
            </h1>
            <p class="text-xs text-[#6f7a6e] mt-1">
                Kelola hak akses staf pustakawan dan akun anggota (pengunjung / mahasiswa).
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <div class="px-3.5 py-2 rounded-xl bg-[#2373F4]/10 border border-[#2373F4]/20 text-[#2373F4] text-xs flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px] text-[#2373F4]">admin_panel_settings</span>
                <span>Super Admin: <strong class="font-bold">{{ $stats['superadmin'] }}</strong></span>
            </div>
            <div class="px-3.5 py-2 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px] text-[#00652c]">local_library</span>
                <span>Pustakawan: <strong class="font-bold">{{ $stats['librarian'] }}</strong></span>
            </div>
            <div class="px-3.5 py-2 rounded-xl bg-blue-50 border border-blue-200 text-blue-900 text-xs flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px] text-blue-700">school</span>
                <span>Anggota: <strong class="font-bold">{{ $stats['member'] }}</strong></span>
            </div>
        </div>
    </div>

    <!-- Filter & Pencarian Pengguna -->
    <div class="bg-white p-4 rounded-2xl border border-[#e6eeff] flex flex-col md:flex-row items-center justify-between gap-3 shadow-xs">
        <form method="GET" action="{{ route('users.index') }}" class="w-full flex flex-col sm:flex-row items-center gap-2.5">
            <div class="relative flex-1 w-full">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <span class="material-symbols-outlined text-[18px]">search</span>
                </span>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari berdasarkan nama atau surel pengguna..."
                       class="w-full pl-9 pr-3 py-2 rounded-xl bg-slate-50 border border-[#dee9fc] text-xs text-[#121c2a] focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
            </div>

            <select name="role"
                    onchange="this.form.submit()"
                    class="w-full sm:w-48 px-3 py-2 rounded-xl bg-slate-50 border border-[#dee9fc] text-xs text-[#121c2a] focus:bg-white focus:outline-none">
                <option value="">Semua Peran</option>
                <option value="superadmin" {{ request('role') === 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                <option value="librarian" {{ request('role') === 'librarian' ? 'selected' : '' }}>Pustakawan</option>
                <option value="member" {{ request('role') === 'member' ? 'selected' : '' }}>Anggota / Mahasiswa</option>
            </select>

            <button type="submit"
                    class="px-4 py-2 rounded-xl bg-[#15803d] text-white text-xs font-semibold hover:bg-[#16a34a] transition-colors flex items-center gap-1.5 shrink-0">
                <span class="material-symbols-outlined text-[16px]">filter_alt</span>
                <span>Filter</span>
            </button>

            @if(request()->hasAny(['search', 'role']))
                <a href="{{ route('users.index') }}"
                   class="px-3 py-2 rounded-xl bg-slate-100 text-[#6f7a6e] hover:text-[#121c2a] text-xs font-semibold transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Tabel Daftar Pengguna -->
    <div class="bg-white rounded-2xl border border-[#e6eeff] overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#f8f9ff] border-b border-[#e6eeff] text-[#6f7a6e] uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="py-3.5 px-4">Pengguna</th>
                        <th class="py-3.5 px-4">Peran Saat Ini</th>
                        <th class="py-3.5 px-4">Kata Sandi</th>
                        <th class="py-3.5 px-4">Pinjaman Aktif</th>
                        <th class="py-3.5 px-4">Terdaftar Sejak</th>
                        <th class="py-3.5 px-4 text-right">Ubah Hak Akses</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f1f5f9]">
                    @forelse($users as $u)
                    <tr class="hover:bg-[#fbfcfe] transition-colors">
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-xs text-white {{ $u->isSuperAdmin() ? 'bg-[#2373F4]' : ($u->isLibrarian() ? 'bg-[#15803d]' : 'bg-slate-600') }}">
                                    {{ strtoupper(substr($u->name, 0, 2)) }}
                                </div>
                                <div>
                                    <span class="font-semibold text-sm text-[#121c2a] block">{{ $u->name }}</span>
                                    <span class="text-[11px] text-[#6f7a6e] font-mono">{{ $u->email }}</span>
                                </div>
                            </div>
                        </td>

                        <td class="py-3.5 px-4">
                            @if($u->isSuperAdmin())
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-[#2373F4]/10 text-[#2373F4] border border-[#2373F4]/20 inline-flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[13px]">shield</span>
                                    <span>Super Admin</span>
                                </span>
                            @elseif($u->isLibrarian())
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-[#00652c] border border-emerald-200 inline-flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[13px]">badge</span>
                                    <span>Pustakawan</span>
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-900 border border-blue-200 inline-flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[13px]">person</span>
                                    <span>Anggota Mahasiswa</span>
                                </span>
                            @endif
                        </td>

                        <!-- Kolom Kata Sandi (Plaintext untuk Super Admin) -->
                        <td class="py-3.5 px-4">
                            <div class="inline-flex items-center gap-1.5 bg-slate-50 border border-slate-200/90 px-2.5 py-1.5 rounded-xl">
                                <span id="pw-text-{{ $u->id }}" class="font-mono text-xs text-slate-700 tracking-wider">••••••••</span>
                                <button type="button"
                                        onclick="toggleUserPassword({{ $u->id }}, '{{ addslashes($u->password) }}')"
                                        title="Tampilkan / Sembunyikan Kata Sandi"
                                        class="p-1 rounded-lg text-slate-400 hover:text-emerald-700 hover:bg-emerald-50 transition cursor-pointer flex items-center justify-center">
                                    <span id="pw-icon-{{ $u->id }}" class="material-symbols-outlined text-[16px]">visibility</span>
                                </button>
                                <button type="button"
                                        onclick="copyUserPassword('{{ addslashes($u->password) }}', this)"
                                        title="Salin Kata Sandi"
                                        class="p-1 rounded-lg text-slate-400 hover:text-blue-700 hover:bg-blue-50 transition cursor-pointer flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[16px]">content_copy</span>
                                </button>
                            </div>
                        </td>

                        <td class="py-3.5 px-4">
                            <span class="font-semibold {{ $u->active_loans_count > 0 ? 'text-amber-700' : 'text-slate-500' }}">
                                {{ $u->active_loans_count }} buku
                            </span>
                        </td>

                        <td class="py-3.5 px-4 text-slate-500">
                            {{ $u->created_at ? $u->created_at->format('d M Y') : 'Awal' }}
                        </td>

                        <td class="py-3.5 px-4 text-right">
                            @if($u->email === 'librarian@athenaeum.test' || $u->id === auth()->id())
                                <span class="text-[11px] text-slate-400 italic">Akun Sistem Utama</span>
                            @else
                                <form method="POST" action="{{ route('users.role', $u) }}" class="inline-flex items-center gap-1.5 justify-end">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role"
                                            class="px-2.5 py-1.5 rounded-lg bg-slate-50 border border-[#dee9fc] text-[11px] font-medium text-[#121c2a] focus:outline-none">
                                        <option value="member" {{ $u->role === 'member' ? 'selected' : '' }}>Anggota</option>
                                        <option value="librarian" {{ $u->role === 'librarian' ? 'selected' : '' }}>Pustakawan</option>
                                        <option value="superadmin" {{ $u->role === 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                                    </select>
                                    <button type="submit"
                                            title="Terapkan Perubahan Peran"
                                            class="px-2.5 py-1.5 bg-[#eff4ff] hover:bg-[#dee9fc] text-[#00652c] rounded-lg text-xs font-semibold transition-colors">
                                        Ubah
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-10 text-center text-slate-400">
                            <span class="material-symbols-outlined text-3xl mb-1 block">search_off</span>
                            <span>Tidak ditemukan data pengguna yang cocok dengan kriteria pencarian.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="p-4 border-t border-[#e6eeff] bg-[#f8f9ff]">
            {{ $users->links() }}
        </div>
        @endif
    </div>

</div>

<!-- Script Toggle & Salin Password Super Admin -->
<script>
    function toggleUserPassword(userId, actualPassword) {
        const textEl = document.getElementById(`pw-text-${userId}`);
        const iconEl = document.getElementById(`pw-icon-${userId}`);
        
        if (textEl.textContent === '••••••••') {
            textEl.textContent = actualPassword;
            textEl.classList.add('text-emerald-800', 'font-bold');
            iconEl.textContent = 'visibility_off';
        } else {
            textEl.textContent = '••••••••';
            textEl.classList.remove('text-emerald-800', 'font-bold');
            iconEl.textContent = 'visibility';
        }
    }

    function copyUserPassword(actualPassword, btn) {
        navigator.clipboard.writeText(actualPassword).then(() => {
            const originalColor = btn.className;
            btn.classList.add('text-emerald-600', 'scale-110');
            setTimeout(() => {
                btn.className = originalColor;
            }, 1200);
        });
    }
</script>
@endsection
