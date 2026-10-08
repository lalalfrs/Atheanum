@extends('layouts.app')

@section('title', 'Laravel & Eloquent Architecture Studio - Athenaeum')
@section('page_category', 'Architecture Studio')

@section('content')
<div class="flex flex-col w-full space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-1 text-[#6f7a6e] text-[11px] uppercase tracking-wider font-bold">
                <span>Developer Console</span>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-[#00652c]">Laravel &amp; Eloquent Architecture</span>
            </div>
            <h1 class="font-headline text-3xl font-bold text-[#121c2a] tracking-tight">
                Laravel &amp; Eloquent Studio
            </h1>
            <p class="text-xs text-[#6f7a6e]">
                Inspeksi arsitektur framework, model Eloquent, rute RESTful, dan eksekusi live query builder secara interaktif.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-[#eff4ff] text-[#00652c] border border-[#dee9fc] flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-[#15803d] animate-pulse"></span>
                <span>Laravel {{ app()->version() }} (PHP {{ PHP_VERSION }})</span>
            </span>
        </div>
    </div>

    <!-- Live Eloquent Query Playground -->
    <div class="bg-white rounded-2xl shadow-xs border border-[#e6eeff] p-6">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between pb-4 border-b border-[#f1f5f9] gap-4 mb-5">
            <div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#15803d] text-[22px]">terminal</span>
                    <h2 class="font-headline font-bold text-lg text-[#121c2a]">Live Eloquent ORM Query Runner</h2>
                </div>
                <p class="text-xs text-[#6f7a6e] mt-0.5">
                    Pilih preset query Eloquent untuk melihat generated SQL query builder dan data JSON yang dihasilkan secara real-time.
                </p>
            </div>
            <!-- Preset Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <button type="button" onclick="runEloquentQuery('critical_stock')"
                        class="query-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-[#15803d] text-white shadow-xs transition-all hover:opacity-90 active:scale-95 flex items-center gap-1.5"
                        data-type="critical_stock">
                    <span class="material-symbols-outlined text-[16px]">warning</span>
                    <span>Book::criticalStock()</span>
                </button>
                <button type="button" onclick="runEloquentQuery('latest_paginate')"
                        class="query-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-[#eff4ff] text-[#00652c] hover:bg-[#d9e3f6] border border-[#dee9fc] transition-all active:scale-95 flex items-center gap-1.5"
                        data-type="latest_paginate">
                    <span class="material-symbols-outlined text-[16px]">update</span>
                    <span>Latest Books (5)</span>
                </button>
                <button type="button" onclick="runEloquentQuery('category_group')"
                        class="query-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-[#eff4ff] text-[#00652c] hover:bg-[#d9e3f6] border border-[#dee9fc] transition-all active:scale-95 flex items-center gap-1.5"
                        data-type="category_group">
                    <span class="material-symbols-outlined text-[16px]">pie_chart</span>
                    <span>Group by Category</span>
                </button>
                <button type="button" onclick="runEloquentQuery('image_storage')"
                        class="query-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-[#eff4ff] text-[#00652c] hover:bg-[#d9e3f6] border border-[#dee9fc] transition-all active:scale-95 flex items-center gap-1.5"
                        data-type="image_storage">
                    <span class="material-symbols-outlined text-[16px]">image</span>
                    <span>Cover Storage URIs</span>
                </button>
            </div>
        </div>

        <!-- Query Output Display -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- SQL Output Panel -->
            <div class="bg-[#0f172a] rounded-xl p-4 text-white flex flex-col font-mono text-xs">
                <div class="flex items-center justify-between pb-2 border-b border-slate-800 mb-3 text-slate-400">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        <span class="font-semibold text-slate-300">Generated SQL (toSql())</span>
                    </div>
                    <span id="queryStatusText" class="text-[11px] text-emerald-400 font-sans">Siap dieksekusi</span>
                </div>
                <div class="p-3 bg-slate-900 rounded-lg border border-slate-800 text-emerald-400 overflow-x-auto min-h-[70px] flex items-center">
                    <code id="sqlDisplayBox">select * from "books" where "stock" &lt;= ? order by "stock" asc</code>
                </div>
                <div class="mt-3 text-[11px] text-slate-400 font-sans flex items-center justify-between">
                    <span>Driver: <strong class="text-slate-200">{{ config('database.default') }}</strong></span>
                    <span>Terkoneksi ke database local</span>
                </div>
            </div>

            <!-- Result JSON Panel -->
            <div class="bg-[#0f172a] rounded-xl p-4 text-white flex flex-col font-mono text-xs">
                <div class="flex items-center justify-between pb-2 border-b border-slate-800 mb-3 text-slate-400">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-sky-400"></span>
                        <span class="font-semibold text-slate-300">Result Collection (JSON)</span>
                    </div>
                    <button type="button" onclick="copyQueryResult()" class="hover:text-white text-slate-400 transition-colors flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">content_copy</span>
                        <span class="text-[11px] font-sans">Salin</span>
                    </button>
                </div>
                <div class="p-3 bg-slate-900 rounded-lg border border-slate-800 text-sky-300 overflow-x-auto overflow-y-auto max-h-[160px]">
                    <pre id="jsonDisplayBox" class="text-xs">Memuat data...</pre>
                </div>
            </div>
        </div>
    </div>

    <!-- Architecture Source Code Explorer -->
    <div class="bg-white rounded-2xl shadow-xs border border-[#e6eeff] p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-[#f1f5f9] gap-4 mb-5">
            <div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#15803d] text-[22px]">code_blocks</span>
                    <h2 class="font-headline font-bold text-lg text-[#121c2a]">Arsitektur Source File Explorer</h2>
                </div>
                <p class="text-xs text-[#6f7a6e] mt-0.5">
                    Inspeksi langsung kode aktual yang sedang berjalan dari direktori aplikasi Laravel.
                </p>
            </div>
            <!-- File Selector Tabs -->
            <div class="flex flex-wrap items-center gap-1.5">
                @foreach($files as $index => $file)
                <button type="button" onclick="switchSourceTab('{{ $file['id'] }}')"
                        id="tab-btn-{{ $file['id'] }}"
                        class="tab-btn px-3 py-1.5 rounded-xl text-xs font-semibold transition-all {{ $index === 0 ? 'bg-[#15803d] text-white shadow-xs' : 'bg-[#eff4ff] text-[#3f493f] hover:bg-[#d9e3f6]' }}">
                    {{ explode(' ', $file['name'])[0] }}
                </button>
                @endforeach
            </div>
        </div>

        <!-- File Panels -->
        @foreach($files as $index => $file)
        <div id="file-panel-{{ $file['id'] }}" class="file-panel {{ $index !== 0 ? 'hidden' : '' }}">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between bg-[#eff4ff] p-3 rounded-xl border border-[#dee9fc] mb-4 gap-2 text-xs">
                <div>
                    <span class="font-bold text-[#121c2a] block">{{ $file['name'] }}</span>
                    <span class="text-[#6f7a6e] font-mono text-[11px]">{{ $file['path'] }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-[#6f7a6e]">{{ $file['description'] }}</span>
                </div>
            </div>

            <div class="bg-[#0f172a] rounded-xl p-4 text-white font-mono text-xs overflow-x-auto max-h-[460px] overflow-y-auto border border-slate-800">
                <pre class="text-slate-200"><code>{{ htmlspecialchars($file['content']) }}</code></pre>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Eloquent & Blade Features Blueprint -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-2xl shadow-xs border border-[#e6eeff]">
            <div class="w-10 h-10 rounded-xl bg-[#eff4ff] text-[#00652c] flex items-center justify-center mb-3">
                <span class="material-symbols-outlined text-[20px]">dataset</span>
            </div>
            <h3 class="font-headline font-bold text-sm text-[#121c2a] mb-1">Eloquent ORM &amp; Relations</h3>
            <p class="text-xs text-[#6f7a6e] leading-relaxed">
                Menggunakan relasi <code class="bg-[#eff4ff] px-1 py-0.5 rounded text-[#00652c]">belongsTo</code> ke model Category, dynamic scopes <code class="bg-[#eff4ff] px-1 py-0.5 rounded text-[#00652c]">criticalStock()</code>, dan accessors virtual untuk URL cover gambar.
            </p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-xs border border-[#e6eeff]">
            <div class="w-10 h-10 rounded-xl bg-[#eff4ff] text-[#00652c] flex items-center justify-center mb-3">
                <span class="material-symbols-outlined text-[20px]">storage</span>
            </div>
            <h3 class="font-headline font-bold text-sm text-[#121c2a] mb-1">File Storage &amp; Asset URL</h3>
            <p class="text-xs text-[#6f7a6e] leading-relaxed">
                Penyimpanan sampul buku menggunakan Laravel Storage Disk <code class="bg-[#eff4ff] px-1 py-0.5 rounded text-[#00652c]">public/covers</code> dengan verifikasi integritas file mime-type dan auto cleanup saat delete.
            </p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-xs border border-[#e6eeff]">
            <div class="w-10 h-10 rounded-xl bg-[#eff4ff] text-[#00652c] flex items-center justify-center mb-3">
                <span class="material-symbols-outlined text-[20px]">view_quilt</span>
            </div>
            <h3 class="font-headline font-bold text-sm text-[#121c2a] mb-1">Blade Template Components</h3>
            <p class="text-xs text-[#6f7a6e] leading-relaxed">
                Struktur layout berbasis Blade modular dengan modal interaktif, toast notifikasi sesi, pencarian keyboard Ctrl+K, serta export format CSV dan SQL dump.
            </p>
        </div>
    </div>
</div>

<script>
    let latestQueryResult = '';

    function switchSourceTab(fileId) {
        document.querySelectorAll('.file-panel').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-[#15803d]', 'text-white', 'shadow-xs');
            btn.classList.add('bg-[#eff4ff]', 'text-[#3f493f]');
        });

        const activePanel = document.getElementById('file-panel-' + fileId);
        if (activePanel) activePanel.classList.remove('hidden');

        const activeBtn = document.getElementById('tab-btn-' + fileId);
        if (activeBtn) {
            activeBtn.classList.remove('bg-[#eff4ff]', 'text-[#3f493f]');
            activeBtn.classList.add('bg-[#15803d]', 'text-white', 'shadow-xs');
        }
    }

    function runEloquentQuery(type) {
        const sqlBox = document.getElementById('sqlDisplayBox');
        const jsonBox = document.getElementById('jsonDisplayBox');
        const statusText = document.getElementById('queryStatusText');

        statusText.textContent = 'Mengeksekusi...';
        sqlBox.textContent = 'Menjalankan query...';
        jsonBox.textContent = 'Memuat respons...';

        document.querySelectorAll('.query-btn').forEach(btn => {
            if (btn.getAttribute('data-type') === type) {
                btn.classList.remove('bg-[#eff4ff]', 'text-[#00652c]', 'border', 'border-[#dee9fc]');
                btn.classList.add('bg-[#15803d]', 'text-white', 'shadow-xs');
            } else {
                btn.classList.remove('bg-[#15803d]', 'text-white', 'shadow-xs');
                btn.classList.add('bg-[#eff4ff]', 'text-[#00652c]', 'border', 'border-[#dee9fc]');
            }
        });

        fetch('{{ route("laravel-studio.query") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ type: type })
        })
        .then(res => res.json())
        .then(data => {
            sqlBox.textContent = data.sql || '(query executed)';
            latestQueryResult = JSON.stringify(data.result, null, 2);
            jsonBox.textContent = latestQueryResult;
            statusText.textContent = 'Selesai (200 OK)';
        })
        .catch(err => {
            sqlBox.textContent = 'Gagal menjalankan query';
            jsonBox.textContent = 'Error: ' + err.message;
            statusText.textContent = 'Error';
        });
    }

    function copyQueryResult() {
        if (latestQueryResult) {
            navigator.clipboard.writeText(latestQueryResult);
            alert('Hasil query berhasil disalin ke clipboard!');
        }
    }

    // Run initial query on page load
    document.addEventListener('DOMContentLoaded', function() {
        runEloquentQuery('critical_stock');
    });
</script>
@endsection
