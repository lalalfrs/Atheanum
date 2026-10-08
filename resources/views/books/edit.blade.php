@extends('layouts.app')

@section('title', 'Edit Buku - ' . $book->title)
@section('page_category', 'Edit Data Buku')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb & Title -->
    <div class="mb-6">
        <div class="flex items-center gap-1 text-[#6f7a6e] text-[11px] uppercase tracking-wider font-bold mb-1">
            <a href="{{ route('books.index') }}" class="hover:underline">Katalog Buku</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-[#00652c]">Perbarui Buku #{{ $book->id }}</span>
        </div>
        <h1 class="font-headline text-2xl font-bold text-[#121c2a] tracking-tight">
            Perbarui Koleksi: {{ $book->title }}
        </h1>
        <p class="text-xs text-[#6f7a6e]">
            Ubah informasi katalog, lokasi fisik di rak perpustakaan, atau ganti file sampul buku.
        </p>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-2xl border border-[#e6eeff] p-6 sm:p-8 shadow-xs">
        <form method="POST" action="{{ route('books.update', $book) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

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
                        <input type="text" name="title" value="{{ old('title', $book->title) }}" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none transition-colors">
                    </div>

                    <!-- Subjudul -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Subjudul / Keterangan Tambahan
                        </label>
                        <input type="text" name="subtitle" value="{{ old('subtitle', $book->subtitle) }}"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none transition-colors">
                    </div>

                    <!-- ISBN -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Nomor ISBN <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}" required
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
                                <option value="{{ $cat->name }}" {{ old('category', $book->category) == $cat->name ? 'selected' : '' }}>
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
                        <input type="text" name="author" value="{{ old('author', $book->author) }}" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none transition-colors">
                    </div>

                    <!-- Penerbit -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Penerbit <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="publisher" value="{{ old('publisher', $book->publisher) }}" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none transition-colors">
                    </div>

                    <!-- Tahun Terbit -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Tahun Terbit <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" name="year" value="{{ old('year', $book->year) }}" min="1900" max="{{ date('Y') + 2 }}" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none transition-colors">
                    </div>

                    <!-- Lokasi Rak Fisik -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Lokasi Rak Penyimpanan <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="shelf_location" value="{{ old('shelf_location', $book->shelf_location) }}" required
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
                        <input type="number" name="stock" id="stockInput" value="{{ old('stock', $book->stock) }}" min="0" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none transition-colors">
                        <span class="text-[10px] text-gray-400 mt-1 block">
                            *Jika stok = 0 otomatis 'Habis', jika &le; 3 'Stok Kritis'
                        </span>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Total Eksemplar Terdaftar
                        </label>
                        <input type="number" name="total_copies" id="copiesInput" value="{{ old('total_copies', $book->total_copies) }}" min="0"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none transition-colors">
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
                    <!-- Current Cover Preview -->
                    <div class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-xl border border-dashed border-gray-200 text-center">
                        <img id="coverPreview" src="{{ $book->cover_url }}" alt="{{ $book->title }}"
                             class="w-32 h-44 object-cover rounded-lg shadow-sm border border-gray-200 mb-2">
                        <span class="text-[11px] text-gray-500 font-medium">Sampul Saat Ini</span>
                    </div>

                    <!-- File Upload or New URL -->
                    <div class="md:col-span-2 flex flex-col gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">
                                Ganti Berkas Gambar (Unggah File Baru)
                            </label>
                            <input type="file" name="cover_file" id="coverFileInput" accept="image/*"
                                   onchange="previewUploadedFile(this)"
                                   class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                            <span class="text-[10px] text-gray-400 mt-1 block">Biarkan kosong jika tidak ingin mengubah sampul saat ini</span>
                        </div>

                        <div class="relative flex py-1 items-center">
                            <div class="flex-grow border-t border-gray-200"></div>
                            <span class="flex-shrink mx-3 text-[11px] text-gray-400 uppercase font-semibold">Atau URL Gambar</span>
                            <div class="flex-grow border-t border-gray-200"></div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">
                                URL Sampul Eksternal (Opsional)
                            </label>
                            <input type="url" name="cover_image" id="coverUrlInput" value="{{ old('cover_image', $book->cover_image) }}"
                                   oninput="previewUrl(this.value)"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none transition-colors">
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
                              class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none transition-colors">{{ old('description', $book->description) }}</textarea>
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
                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                    <span>Perbarui Data Buku</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
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
</script>
@endsection
