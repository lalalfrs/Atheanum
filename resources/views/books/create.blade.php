@extends('layouts.app')

@section('title', 'Tambah Buku Baru - Athenaeum')
@section('page_category', 'Tambah Koleksi Buku')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb & Title -->
    <div class="mb-6">
        <div class="flex items-center gap-1 text-[#6f7a6e] text-[11px] uppercase tracking-wider font-bold mb-1">
            <a href="{{ route('books.index') }}" class="hover:underline">Katalog Buku</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-[#00652c]">Pendaftaran Buku Baru</span>
        </div>
        <h1 class="font-headline text-2xl font-bold text-[#121c2a] tracking-tight">
            Registrasi Eksemplar Koleksi Baru
        </h1>
        <p class="text-xs text-[#6f7a6e]">
            Masukkan informasi bibliografi, data sirkulasi rak, dan unggah berkas sampul buku ke basis data.
        </p>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-2xl border border-[#e6eeff] p-6 sm:p-8 shadow-xs">
        <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Section 1: Informasi Bibliografi Utama -->
            <div>
                <h3 class="font-headline font-bold text-sm text-gray-900 mb-4 flex items-center gap-2 pb-2 border-b border-gray-100">
                    <span class="material-symbols-outlined text-emerald-700 text-[20px]">auto_stories</span>
                    <span>1. Informasi Bibliografi</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Judul Buku -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Judul Utama Buku <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title') }}" required
                               placeholder="Contoh: Atomic Habits, Filosofi Teras..."
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none transition-colors">
                    </div>

                    <!-- Subjudul -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Subjudul / Keterangan Tambahan
                        </label>
                        <input type="text" name="subtitle" value="{{ old('subtitle') }}"
                               placeholder="Contoh: Perubahan Kecil yang Memberikan Hasil Luar Biasa"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none transition-colors">
                    </div>

                    <!-- ISBN -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-semibold text-gray-700">
                                Nomor ISBN <span class="text-rose-500">*</span>
                            </label>
                            <button type="button" onclick="generateRandomIsbn()" class="text-[11px] text-emerald-700 hover:underline font-semibold">
                                + Acak ISBN
                            </button>
                        </div>
                        <input type="text" name="isbn" id="isbnInput" value="{{ old('isbn') }}" required
                               placeholder="Contoh: 978-602-03-8591-4"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs font-mono text-gray-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none transition-colors">
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Kategori Klasifikasi DDC <span class="text-rose-500">*</span>
                        </label>
                        <select name="category" required
                                class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none transition-colors cursor-pointer">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->name }}" {{ old('category') == $cat->name ? 'selected' : '' }}>
                                    {{ $cat->name }} (DDC {{ $cat->ddc_code }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Penulis -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Nama Penulis / Pengarang <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="author" value="{{ old('author') }}" required
                               placeholder="Contoh: James Clear, Pramoedya Ananta Toer..."
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none transition-colors">
                    </div>

                    <!-- Penerbit -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Penerbit <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="publisher" value="{{ old('publisher') }}" required
                               placeholder="Contoh: Gramedia Pustaka Utama, Penerbit Erlangga..."
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none transition-colors">
                    </div>

                    <!-- Tahun Terbit -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Tahun Terbit <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" name="year" value="{{ old('year', date('Y')) }}" min="1900" max="{{ date('Y') + 2 }}" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none transition-colors">
                    </div>

                    <!-- Lokasi Rak Fisik -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Lokasi Rak Penyimpanan <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="shelf_location" value="{{ old('shelf_location', 'Rak A-01') }}" required
                               placeholder="Contoh: Rak A-12, Rak B-08, Rak T-01..."
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none transition-colors">
                    </div>
                </div>
            </div>

            <!-- Section 2: Inventaris & Jumlah Eksemplar -->
            <div>
                <h3 class="font-headline font-bold text-sm text-gray-900 mb-4 flex items-center gap-2 pb-2 border-b border-gray-100">
                    <span class="material-symbols-outlined text-emerald-700 text-[20px]">inventory_2</span>
                    <span>2. Stok &amp; Eksemplar Fisik</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Jumlah Stok Tersedia di Rak <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" name="stock" id="stockInput" value="{{ old('stock', 10) }}" min="0" required
                               onchange="document.getElementById('copiesInput').value = this.value"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none transition-colors">
                        <span class="text-[10px] text-gray-400 mt-1 block">
                            *Jika stok = 0 otomatis berstatus 'Habis', jika &le; 3 berstatus 'Stok Kritis'
                        </span>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Total Eksemplar Terdaftar
                        </label>
                        <input type="number" name="total_copies" id="copiesInput" value="{{ old('total_copies', 10) }}" min="0"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none transition-colors">
                        <span class="text-[10px] text-gray-400 mt-1 block">
                            Total kepemilikan fisik termasuk yang sedang dipinjam
                        </span>
                    </div>
                </div>
            </div>

            <!-- Section 3: Sampul Buku (Cover Image) -->
            <div>
                <h3 class="font-headline font-bold text-sm text-gray-900 mb-4 flex items-center gap-2 pb-2 border-b border-gray-100">
                    <span class="material-symbols-outlined text-emerald-700 text-[20px]">image</span>
                    <span>3. Berkas Sampul Buku (Cover)</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Preview Cover -->
                    <div class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-xl border border-dashed border-gray-200 text-center">
                        <img id="coverPreview"
                             src="https://lh3.googleusercontent.com/aida-public/AB6AXuCFDBQosu4lBnJao3h9KL0iR0jVaOFwYEmC4mppJPQHCrc5yxG05H0N7sBros66J5zBYOC-FiqmFuzRsw0w0mtn2VkWbZbEzFMLPJqHBGgNgCUJ8sHcrPTh71b1iv37mr64OKd5KGkoIVI63ULdQWgogSYG58Pt8rrD_rv0X4uj4VBWHzKZ0Da4AOerXjRHXWZ0qV01zEMeEj4s7PyqeEv0Jy9l7tLWfFAycKUtsRZjmVA2mV5czPu1"
                             alt="Preview" class="w-32 h-44 object-cover rounded-lg shadow-sm border border-gray-200 mb-2">
                        <span class="text-[11px] text-gray-500 font-medium">Pratinjau Sampul</span>
                    </div>

                    <!-- Input Options -->
                    <div class="md:col-span-2 flex flex-col gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">
                                Unggah Berkas Gambar (Disimpan ke Storage Laravel)
                            </label>
                            <input type="file" name="cover_file" id="coverFileInput" accept="image/*"
                                   onchange="previewUploadedFile(this)"
                                   class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                            <span class="text-[10px] text-gray-400 mt-1 block">Mendukung JPEG, PNG, WEBP (maksimal 5MB)</span>
                        </div>

                        <div class="relative flex py-1 items-center">
                            <div class="flex-grow border-t border-gray-200"></div>
                            <span class="flex-shrink mx-3 text-[11px] text-gray-400 uppercase font-semibold">Atau Gunakan Tautan URL / Preset</span>
                            <div class="flex-grow border-t border-gray-200"></div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">
                                URL Gambar Sampul Eksternal
                            </label>
                            <input type="url" name="cover_image" id="coverUrlInput" value="{{ old('cover_image') }}"
                                   placeholder="https://... (URL gambar)"
                                   oninput="previewUrl(this.value)"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none transition-colors">
                        </div>

                        <!-- Presets Selector -->
                        <div>
                            <span class="text-[11px] font-semibold text-gray-600 block mb-1.5">Pilihan Cepat Sampul Populer:</span>
                            <div class="flex items-center gap-2 overflow-x-auto py-1">
                                <button type="button" onclick="selectPreset('https://lh3.googleusercontent.com/aida-public/AB6AXuCFDBQosu4lBnJao3h9KL0iR0jVaOFwYEmC4mppJPQHCrc5yxG05H0N7sBros66J5zBYOC-FiqmFuzRsw0w0mtn2VkWbZbEzFMLPJqHBGgNgCUJ8sHcrPTh71b1iv37mr64OKd5KGkoIVI63ULdQWgogSYG58Pt8rrD_rv0X4uj4VBWHzKZ0Da4AOerXjRHXWZ0qV01zEMeEj4s7PyqeEv0Jy9l7tLWfFAycKUtsRZjmVA2mV5czPu1')" class="px-2.5 py-1 rounded bg-gray-100 hover:bg-emerald-50 text-[11px] text-gray-700 border border-gray-200 flex-shrink-0">
                                    Atomic Habits
                                </button>
                                <button type="button" onclick="selectPreset('https://lh3.googleusercontent.com/aida-public/AB6AXuAylDzhS69C6c_wFZDHdgwm1Ypy31UFEHMxhTitS9DFZODJtje34dJmVbrMw7HQ53upC5KYfWXtzGBmv3uIQ7Kz51DKUA6sd6VnZ3LRN3e5C0gE44u-iMNjF5Z60NzFgg_9aMqZpZdpiz3fenEhI02YN71v2W-7CRI3lOKWL08iA_Zs2mM41ecOs7oKRwq9ftnFZF7yDF2zpidL9TtiRcioUFMJqQVs257UHMoQr1fe5nkgLziOjVCd')" class="px-2.5 py-1 rounded bg-gray-100 hover:bg-emerald-50 text-[11px] text-gray-700 border border-gray-200 flex-shrink-0">
                                    Filosofi Teras
                                </button>
                                <button type="button" onclick="selectPreset('https://lh3.googleusercontent.com/aida-public/AB6AXuBFGNT3XheiIYPlqxxSefMAz_14hOzFOGeEvZmIwpfN4tZ9H6dkBFmKMPqAwTEYpm97YTdnoV9FJ7ZVP4hpUfwH8zqJh6C2NXm6x08q0H-3ur5-NQO8BzexbmgTo_aABfX3ijppIgO_GoWZd_HCZszRMlGCyTtXw8h704MJHq6OX0r4djSjSj0lBmgwQBD9xhct1bdW0_95kJOv9h9YF3dkME8kjK0dxTSGiZoeokYQIdb_xMV0lNls')" class="px-2.5 py-1 rounded bg-gray-100 hover:bg-emerald-50 text-[11px] text-gray-700 border border-gray-200 flex-shrink-0">
                                    Clean Architecture
                                </button>
                                <button type="button" onclick="selectPreset('https://lh3.googleusercontent.com/aida-public/AB6AXuBithebMUdUulLyhN5WrNVtvuyJ9pU7uDrz_Sdu0qeZvV4eFB-SRng3nMsx04M82pJz-rCXuAvwRc5lKaKIDjqHxWBOVWxbCk38sEo9Y6BSp6VBOXP7FtO26yIxzW1mqNwNYFQTEYPgDey2lQ7Vp4zCKmU-IgUBIm5Ctlh0j61D1_83bhZl3wS0TFiqa8pqhBJPj5HFG_i3BTQEsUyE7DJtWSa1oHyV0O4kMPtX8TrcINU2AMf98WLv')" class="px-2.5 py-1 rounded bg-gray-100 hover:bg-emerald-50 text-[11px] text-gray-700 border border-gray-200 flex-shrink-0">
                                    Laskar Pelangi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 4: Deskripsi & Sinopsis -->
            <div>
                <h3 class="font-headline font-bold text-sm text-gray-900 mb-4 flex items-center gap-2 pb-2 border-b border-gray-100">
                    <span class="material-symbols-outlined text-emerald-700 text-[20px]">description</span>
                    <span>4. Deskripsi &amp; Ringkasan</span>
                </h3>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Sinopsis / Catatan Bibliografi
                    </label>
                    <textarea name="description" rows="4"
                              placeholder="Masukkan ringkasan singkat buku, topik utama, atau catatan katalog..."
                              class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none transition-colors">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('books.index') }}"
                   class="px-5 py-2.5 rounded-xl text-xs font-semibold text-gray-600 hover:bg-gray-100 transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-[#15803d] hover:bg-[#00652c] text-white rounded-xl text-xs font-bold shadow-md transition-all active:scale-95 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    <span>Simpan Buku ke Database</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function generateRandomIsbn() {
        const p1 = Math.floor(10 + Math.random() * 89);
        const p2 = Math.floor(1000 + Math.random() * 8999);
        const p3 = Math.floor(1 + Math.random() * 9);
        document.getElementById('isbnInput').value = `978-602-${p1}-${p2}-${p3}`;
    }

    function previewUploadedFile(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('coverPreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewUrl(url) {
        if (url && (url.startsWith('http://') || url.startsWith('https://'))) {
            document.getElementById('coverPreview').src = url;
        }
    }

    function selectPreset(url) {
        document.getElementById('coverUrlInput').value = url;
        document.getElementById('coverPreview').src = url;
        document.getElementById('coverFileInput').value = '';
    }
</script>
@endsection
