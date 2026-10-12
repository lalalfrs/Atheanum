@extends('layouts.public')

@section('title', 'Chat & Bantuan')

@section('content')
<div class="space-y-12">

    <!-- Header Section -->
    <div class="bg-white p-6 sm:p-10 rounded-3xl border border-border-light shadow-xs space-y-3">
        <div class="flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-[#2373F4]"></span>
            <span class="text-xs uppercase font-bold tracking-wider text-[#2373F4]">Layanan Mandiri</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-text-primary tracking-tight">
            Chat Asisten &amp; Pusat Bantuan Pemustaka
        </h1>
        <p class="text-sm text-text-secondary max-w-2xl leading-relaxed">
            Dapatkan jawaban cepat seputar tata cara peminjaman, perpanjangan buku, aturan denda, hingga pencarian katalog e-book secara instan bersama Asisten Virtual Perpustakaan.
        </p>
    </div>

    <!-- Dual Column: Interactive Chatbot & FAQ -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- INTERACTIVE CHATBOT (Matches Flowchart "Pindah ke halaman chatbot") -->
        <div class="lg:col-span-7 bg-white rounded-3xl border border-border-light shadow-xs overflow-hidden flex flex-col h-[580px]">
            <!-- Chatbot Header -->
            <div class="bg-forest text-white p-4 sm:p-5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-[#2373F4] text-white flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-[22px]">smart_toy</span>
                    </div>
                    <div>
                        <h2 class="font-bold text-sm sm:text-base leading-tight">Asisten Virtual Athenaeum</h2>
                        <span class="inline-flex items-center gap-1.5 text-[11px] text-emerald-300">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span>Online &amp; Siap Membantu</span>
                        </span>
                    </div>
                </div>
                <button type="button" onclick="resetChat()" class="text-xs text-emerald-200 hover:text-white flex items-center gap-1 cursor-pointer">
                    <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                    <span>Reset</span>
                </button>
            </div>

            <!-- Chat Messages Log -->
            <div id="chatMessages" class="flex-1 p-4 sm:p-6 overflow-y-auto space-y-4 bg-slate-50/60 text-xs sm:text-sm">
                <!-- Bot Welcome Message -->
                <div class="flex items-start gap-2.5 max-w-[85%]">
                    <div class="w-7 h-7 rounded-lg bg-[#2373F4] text-white flex items-center justify-center shrink-0 text-xs font-bold">
                        <span class="material-symbols-outlined text-[16px]">smart_toy</span>
                    </div>
                    <div class="bg-white p-3.5 rounded-2xl rounded-tl-xs border border-border-light shadow-2xs space-y-2">
                        <p class="text-text-primary leading-relaxed">
                            Halo! Selamat datang di layanan bantuan virtual perpustakaan. Ada yang bisa saya bantu hari ini? Anda bisa mengetik pertanyaan atau memilih topik cepat di bawah:
                        </p>
                        <div class="flex flex-wrap gap-1.5 pt-1">
                            <button type="button" onclick="quickAsk('Bagaimana cara meminjam buku?')" class="px-2.5 py-1 rounded-lg bg-surface-grey hover:bg-[#2373F4]/10 hover:text-[#2373F4] text-xs font-medium transition-colors cursor-pointer">
                                📖 Cara Pinjam Buku
                            </button>
                            <button type="button" onclick="quickAsk('Berapa denda keterlambatan buku?')" class="px-2.5 py-1 rounded-lg bg-surface-grey hover:bg-[#2373F4]/10 hover:text-[#2373F4] text-xs font-medium transition-colors cursor-pointer">
                                💰 Ketentuan Denda
                            </button>
                            <button type="button" onclick="quickAsk('Bagaimana cara memperpanjang pinjaman?')" class="px-2.5 py-1 rounded-lg bg-surface-grey hover:bg-[#2373F4]/10 hover:text-[#2373F4] text-xs font-medium transition-colors cursor-pointer">
                                🔄 Perpanjangan Buku
                            </button>
                            <button type="button" onclick="quickAsk('Apakah e-book bisa dibaca gratis?')" class="px-2.5 py-1 rounded-lg bg-surface-grey hover:bg-[#2373F4]/10 hover:text-[#2373F4] text-xs font-medium transition-colors cursor-pointer">
                                📱 Akses E-Book
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Input Box -->
            <form id="chatForm" onsubmit="handleChatSubmit(event)" class="p-3 sm:p-4 bg-white border-t border-border-light flex items-center gap-2">
                <input type="text"
                       id="chatInput"
                       placeholder="Ketik pertanyaan seputar perpustakaan di sini..."
                       required
                       class="flex-1 px-4 py-2.5 rounded-xl bg-slate-50 border border-border-light text-xs sm:text-sm focus:outline-none focus:bg-white focus:ring-2 focus:ring-[#2373F4]/20">
                <button type="submit"
                        class="px-4 py-2.5 rounded-xl bg-[#2373F4] hover:bg-[#1A5EC4] text-white text-xs sm:text-sm font-semibold transition-colors flex items-center gap-1.5 shrink-0 cursor-pointer">
                    <span class="material-symbols-outlined text-[18px]">send</span>
                    <span class="hidden sm:inline">Kirim</span>
                </button>
            </form>
        </div>

        <!-- FAQ & PANDUAN PENTING -->
        <div class="lg:col-span-5 space-y-4">
            <div class="bg-white p-6 rounded-3xl border border-border-light shadow-xs space-y-3">
                <div class="flex items-center gap-2 text-forest">
                    <span class="material-symbols-outlined text-[20px]">help</span>
                    <h2 class="font-bold text-base text-text-primary">Pertanyaan yang Sering Diajukan (FAQ)</h2>
                </div>
                <p class="text-xs text-text-muted">Panduan singkat ketentuan perpustakaan resmi.</p>
            </div>

            <!-- FAQ Items -->
            <div class="space-y-3">
                <details class="bg-white p-4 rounded-2xl border border-border-light shadow-xs group">
                    <summary class="font-bold text-xs sm:text-sm text-text-primary cursor-pointer flex items-center justify-between list-none">
                        <span>Berapa kuota maksimal peminjaman buku?</span>
                        <span class="material-symbols-outlined text-[18px] text-text-muted group-open:rotate-180 transition-transform">expand_more</span>
                    </summary>
                    <p class="text-xs text-text-secondary mt-2.5 leading-relaxed border-t border-slate-100 pt-2">
                        Setiap anggota mahasiswa/pengunjung dapat meminjam maksimal <strong>3 buku fisik aktif</strong> secara bersamaan. Jika kuota penuh, buku sebelumnya harus dikembalikan terlebih dahulu.
                    </p>
                </details>

                <details class="bg-white p-4 rounded-2xl border border-border-light shadow-xs group">
                    <summary class="font-bold text-xs sm:text-sm text-text-primary cursor-pointer flex items-center justify-between list-none">
                        <span>Bagaimana aturan perpanjangan masa pinjam?</span>
                        <span class="material-symbols-outlined text-[18px] text-text-muted group-open:rotate-180 transition-transform">expand_more</span>
                    </summary>
                    <p class="text-xs text-text-secondary mt-2.5 leading-relaxed border-t border-slate-100 pt-2">
                        Peminjaman buku berdurasi standar 7 hari dan dapat diperpanjang mandiri sebanyak <strong>1 kali (+7 hari)</strong> sebelum jatuh tempo. Buku yang sudah lewat tanggal jatuh tempo tidak dapat diperpanjang dan harus segera dikembalikan.
                    </p>
                </details>

                <details class="bg-white p-4 rounded-2xl border border-border-light shadow-xs group">
                    <summary class="font-bold text-xs sm:text-sm text-text-primary cursor-pointer flex items-center justify-between list-none">
                        <span>Bagaimana jika terlambat mengembalikan buku?</span>
                        <span class="material-symbols-outlined text-[18px] text-text-muted group-open:rotate-180 transition-transform">expand_more</span>
                    </summary>
                    <p class="text-xs text-text-secondary mt-2.5 leading-relaxed border-t border-slate-100 pt-2">
                        Denda keterlambatan adalah <strong>Rp 1.000 per hari per buku</strong>. Anggota yang memiliki tagihan denda belum lunas diblokir dari peminjaman buku baru sampai denda diselesaikan di meja pustakawan.
                    </p>
                </details>

                <details class="bg-white p-4 rounded-2xl border border-border-light shadow-xs group">
                    <summary class="font-bold text-xs sm:text-sm text-text-primary cursor-pointer flex items-center justify-between list-none">
                        <span>Apakah e-book digital bisa dibaca tanpa login?</span>
                        <span class="material-symbols-outlined text-[18px] text-text-muted group-open:rotate-180 transition-transform">expand_more</span>
                    </summary>
                    <p class="text-xs text-text-secondary mt-2.5 leading-relaxed border-t border-slate-100 pt-2">
                        Ya! Seluruh koleksi e-book digital dapat dibaca secara gratis dan mandiri langsung di browser oleh seluruh pengunjung dan mahasiswa melalui menu E-Book.
                    </p>
                </details>
            </div>
        </div>

    </div>

</div>

@push('scripts')
<script>
    const knowledgeBase = [
        {
            keywords: ['pinjam', 'meminjam', 'cara pinjam', 'kuota', 'berapa buku'],
            answer: 'Untuk meminjam buku fisik, Anda dapat membuka menu Katalog/OPAC atau Detail Buku lalu klik "Pinjam Buku Ini". Setiap anggota memiliki batas kuota maksimal 3 buku dengan masa pinjam standar 7 hari.'
        },
        {
            keywords: ['denda', 'terlambat', 'telat', 'biaya', 'bayar'],
            answer: 'Denda keterlambatan buku adalah Rp 1.000 per hari untuk setiap buku yang terlambat. Anggota dengan tagihan denda belum lunas akan diblokir dari meminjam buku baru sampai denda dilunasi di meja pustakawan.'
        },
        {
            keywords: ['perpanjang', 'perpanjangan', 'tambah hari', 'extend', 'renew'],
            answer: 'Masa peminjaman dapat diperpanjang mandiri sebanyak 1 kali (+7 hari) melalui tombol "+7 Hari" di Dashboard atau menu Sirkulasi, dengan syarat buku belum melewati tanggal jatuh tempo.'
        },
        {
            keywords: ['ebook', 'e-book', 'digital', 'baca online', 'naskah'],
            answer: 'Koleksi E-Book Digital dapat diakses langsung tanpa syarat di menu "E-Book Digital". Tersedia fitur navigasi halaman dan pembaca interaktif langsung di peramban.'
        },
        {
            keywords: ['jam', 'buka', 'jadwal', 'operasional', 'tutup'],
            answer: 'Perpustakaan buka Senin s/d Kamis pukul 08.00 - 16.30 WIB dan Jumat pukul 08.00 - 16.00 WIB. Sabtu, Minggu, dan tanggal merah nasional libur.'
        },
        {
            keywords: ['kontak', 'alamat', 'lokasi', 'telepon', 'whatsapp', 'email'],
            answer: 'Perpustakaan berlokasi di Gedung Perpustakaan Kampus Terpadu. Anda juga dapat menghubungi email perpustakaan@mncu.ac.id atau WhatsApp pengelola di menu Kontak.'
        },
        {
            keywords: ['halo', 'hai', 'pagi', 'siang', 'sore', 'malam'],
            answer: 'Halo! Saya asisten virtual perpustakaan. Silakan tanyakan hal seputar katalog, tata cara peminjaman buku, denda, atau koleksi e-book digital.'
        }
    ];

    function handleChatSubmit(event) {
        event.preventDefault();
        const input = document.getElementById('chatInput');
        const text = input.value.trim();
        if (!text) return;

        appendUserMessage(text);
        input.value = '';

        setTimeout(() => {
            const answer = findAnswer(text);
            appendBotMessage(answer);
        }, 400);
    }

    function quickAsk(text) {
        appendUserMessage(text);
        setTimeout(() => {
            const answer = findAnswer(text);
            appendBotMessage(answer);
        }, 400);
    }

    function findAnswer(query) {
        const lower = query.toLowerCase();
        for (const item of knowledgeBase) {
            if (item.keywords.some(k => lower.includes(k))) {
                return item.answer;
            }
        }
        return 'Pertanyaan Anda sangat menarik! Untuk informasi lebih spesifik mengenai topik tersebut, Anda dapat mengecek menu FAQ di sebelah kanan atau menghubungi staf pustakawan kami via menu Kontak.';
    }

    function appendUserMessage(text) {
        const container = document.getElementById('chatMessages');
        const wrap = document.createElement('div');
        wrap.className = 'flex items-start gap-2.5 max-w-[85%] ml-auto justify-end';
        wrap.innerHTML = `
            <div class="bg-forest text-white p-3.5 rounded-2xl rounded-tr-xs shadow-2xs">
                <p class="leading-relaxed">${escapeHtml(text)}</p>
            </div>
            <div class="w-7 h-7 rounded-lg bg-forest text-white flex items-center justify-center shrink-0 text-xs font-bold">
                <span class="material-symbols-outlined text-[16px]">person</span>
            </div>
        `;
        container.appendChild(wrap);
        container.scrollTop = container.scrollHeight;
    }

    function appendBotMessage(text) {
        const container = document.getElementById('chatMessages');
        const wrap = document.createElement('div');
        wrap.className = 'flex items-start gap-2.5 max-w-[85%]';
        wrap.innerHTML = `
            <div class="w-7 h-7 rounded-lg bg-[#2373F4] text-white flex items-center justify-center shrink-0 text-xs font-bold">
                <span class="material-symbols-outlined text-[16px]">smart_toy</span>
            </div>
            <div class="bg-white p-3.5 rounded-2xl rounded-tl-xs border border-border-light shadow-2xs">
                <p class="text-text-primary leading-relaxed">${escapeHtml(text)}</p>
            </div>
        `;
        container.appendChild(wrap);
        container.scrollTop = container.scrollHeight;
    }

    function resetChat() {
        const container = document.getElementById('chatMessages');
        container.innerHTML = `
            <div class="flex items-start gap-2.5 max-w-[85%]">
                <div class="w-7 h-7 rounded-lg bg-[#2373F4] text-white flex items-center justify-center shrink-0 text-xs font-bold">
                    <span class="material-symbols-outlined text-[16px]">smart_toy</span>
                </div>
                <div class="bg-white p-3.5 rounded-2xl rounded-tl-xs border border-border-light shadow-2xs space-y-2">
                    <p class="text-text-primary leading-relaxed">
                        Halo! Sesi obrolan telah direset. Silakan tanyakan informasi seputar layanan perpustakaan:
                    </p>
                </div>
            </div>
        `;
    }

    function escapeHtml(string) {
        const div = document.createElement('div');
        div.textContent = string;
        return div.innerHTML;
    }
</script>
@endpush
@endsection
