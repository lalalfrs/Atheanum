@if(session('success'))
<div id="toast-success" role="status" class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl flex items-center justify-between gap-3">
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-xl bg-forest text-white flex items-center justify-center flex-shrink-0">
            <span class="material-symbols-outlined text-[20px]">check_circle</span>
        </div>
        <div>
            <span class="font-bold text-sm block">Berhasil:</span>
            <span class="text-xs text-green-700">{{ session('success') }}</span>
        </div>
    </div>
    <button onclick="document.getElementById('toast-success').remove()" type="button" aria-label="Tutup notifikasi" class="text-green-600 hover:text-green-900 p-1">
        <span class="material-symbols-outlined text-[18px]">close</span>
    </button>
</div>
@endif

@if(session('error') || $errors->any())
<div id="toast-error" role="alert" class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl flex items-center justify-between gap-3">
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-xl bg-red-600 text-white flex items-center justify-center flex-shrink-0">
            <span class="material-symbols-outlined text-[20px]">error</span>
        </div>
        <div>
            <span class="font-bold text-sm block">Terjadi Kesalahan:</span>
            <ul class="text-xs text-red-700 list-disc list-inside">
                @if(session('error'))
                    <li>{{ session('error') }}</li>
                @endif
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <button onclick="document.getElementById('toast-error').remove()" type="button" aria-label="Tutup notifikasi" class="text-red-600 hover:text-red-900 p-1">
        <span class="material-symbols-outlined text-[18px]">close</span>
    </button>
</div>
@endif
