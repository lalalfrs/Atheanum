@extends('layouts.public')

@section('title', 'Kontak')

@section('content')
<div class="space-y-12">

    <!-- Header Section -->
    <div class="bg-white p-6 sm:p-10 rounded-3xl border border-border-light shadow-xs space-y-3">
        <div class="flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-[#2373F4]"></span>
            <span class="text-xs uppercase font-bold tracking-wider text-[#2373F4]">Hubungi Kami</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-text-primary tracking-tight">
            Kontak Pengelola Perpustakaan
        </h1>
        <p class="text-sm text-text-secondary max-w-2xl leading-relaxed">
            Perlu informasi mengenai keanggotaan, sirkulasi buku, deposit karya ilmiah, atau bantuan referensi riset? Silakan hubungi staf pengelola kami.
        </p>
    </div>

    <!-- Contact Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Direct Contacts -->
        <div class="space-y-4">
            <div class="bg-white p-6 rounded-3xl border border-border-light shadow-xs space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-forest text-white flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-[24px]">call</span>
                </div>
                <h2 class="text-lg font-bold text-text-primary">Telepon &amp; WhatsApp</h2>
                <div class="space-y-1 text-xs sm:text-sm text-text-secondary">
                    <p class="font-semibold text-text-primary">{{ $contact['phone'] ?: '+62 21 8901 2345' }}</p>
                    <p class="text-xs text-text-muted">Layanan WhatsApp Sirkulasi: {{ $contact['whatsapp'] ?: '+62 812 3456 7890' }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-border-light shadow-xs space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-[#2373F4] text-white flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-[24px]">mail</span>
                </div>
                <h2 class="text-lg font-bold text-text-primary">Surat Elektronik (Email)</h2>
                <div class="space-y-1 text-xs sm:text-sm text-text-secondary">
                    <a href="mailto:{{ $contact['email'] ?: 'perpustakaan@mncu.ac.id' }}" class="font-semibold text-[#2373F4] hover:underline block">
                        {{ $contact['email'] ?: 'perpustakaan@mncu.ac.id' }}
                    </a>
                    <p class="text-xs text-text-muted">Respon maksimal 1x24 jam kerja.</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-border-light shadow-xs space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-[24px]">schedule</span>
                </div>
                <h2 class="text-lg font-bold text-text-primary">Jam Layanan Fisik</h2>
                <div class="space-y-1 text-xs text-text-secondary">
                    <p><strong class="text-text-primary">Senin - Kamis:</strong> 08.00 - 16.30 WIB</p>
                    <p><strong class="text-text-primary">Jumat:</strong> 08.00 - 16.00 WIB (Istirahat 11.30 - 13.00)</p>
                    <p><strong class="text-text-primary">Sabtu &amp; Minggu / Hari Libur:</strong> Tutup</p>
                </div>
            </div>
        </div>

        <!-- Contact Form / Kirim Pesan -->
        <div class="lg:col-span-2 bg-white p-6 sm:p-10 rounded-3xl border border-border-light shadow-xs space-y-6">
            <div class="border-b border-border-light pb-4">
                <h2 class="text-xl font-bold text-text-primary">Kirim Pesan / Pengaduan Pemustaka</h2>
                <p class="text-xs text-text-muted mt-1">Sampaikan pertanyaan seputar literatur atau kendala layanan perpustakaan.</p>
            </div>

            <form onsubmit="event.preventDefault(); alert('Terima kasih! Pesan Anda telah diterima oleh bagian layanan perpustakaan.'); this.reset();" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-text-primary mb-1">Nama Lengkap</label>
                        <input type="text" required placeholder="Nama Anda" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-border-light text-xs sm:text-sm focus:outline-none focus:bg-white focus:ring-2 focus:ring-[#2373F4]/20">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-text-primary mb-1">Email / WhatsApp</label>
                        <input type="text" required placeholder="email@domain.com" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-border-light text-xs sm:text-sm focus:outline-none focus:bg-white focus:ring-2 focus:ring-[#2373F4]/20">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-primary mb-1">Subjek Pertanyaan</label>
                    <select class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-border-light text-xs sm:text-sm focus:outline-none focus:bg-white">
                        <option>Pertanyaan Umum &amp; Keanggotaan</option>
                        <option>Sirkulasi &amp; Denda Buku</option>
                        <option>Akses Repositori &amp; E-Journal</option>
                        <option>Usulan Pengadaan Buku Baru</option>
                        <option>Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-primary mb-1">Isi Pesan</label>
                    <textarea rows="4" required placeholder="Tuliskan pesan atau pertanyaan Anda di sini..." class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-border-light text-xs sm:text-sm focus:outline-none focus:bg-white focus:ring-2 focus:ring-[#2373F4]/20"></textarea>
                </div>

                <button type="submit" class="px-6 py-3 rounded-xl bg-[#2373F4] hover:bg-[#1A5EC4] text-white text-xs sm:text-sm font-semibold transition-colors flex items-center gap-2 cursor-pointer">
                    <span class="material-symbols-outlined text-[18px]">send</span>
                    <span>Kirim Pesan</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Peta Lokasi Gedung -->
    <div class="bg-white p-6 sm:p-10 rounded-3xl border border-border-light shadow-xs space-y-4">
        <h2 class="text-xl font-bold text-text-primary flex items-center gap-2">
            <span class="material-symbols-outlined text-rose-500">location_on</span>
            <span>Lokasi Fisik Gedung Perpustakaan</span>
        </h2>
        <div class="rounded-2xl overflow-hidden border border-border-light h-80 bg-slate-100">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7639.176983907385!2d106.76078576880916!3d-6.165786488848673!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f755f4008685%3A0xff5d1632dbcc3042!2sMNC%20University!5e0!3m2!1sen!2sid!4v1791854863659!5m2!1sen!2sid"
                width="100%"
                height="100%"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="strict-origin-when-cross-origin"
                title="Peta Lokasi MNC University"
                class="w-full h-full">
            </iframe>
        </div>
    </div>

</div>
@endsection
