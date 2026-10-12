<?php

/*
|--------------------------------------------------------------------------
| Profil & Tautan Perpustakaan
|--------------------------------------------------------------------------
|
| Data yang tampil di beranda publik. Nilai kosong (null) sengaja tidak
| diisi tebakan: halaman akan menampilkan keterangan "belum diatur" sampai
| nilai aslinya diisi lewat file .env.
|
*/

return [

    'name' => env('LIBRARY_NAME', 'Athenaeum Library'),

    'tagline' => env('LIBRARY_TAGLINE', 'Katalog, sirkulasi, dan koleksi digital dalam satu tempat.'),

    'contact' => [
        'address' => env('LIBRARY_ADDRESS'),
        'phone' => env('LIBRARY_PHONE'),
        'whatsapp' => env('LIBRARY_WHATSAPP'),
        'email' => env('LIBRARY_EMAIL'),
        'hours' => env('LIBRARY_HOURS'),
    ],

    /*
    | Teks pencarian Google Maps, contoh: "Perpustakaan Pusat Universitas X".
    */
    'map_query' => env('LIBRARY_MAP_QUERY'),

    'links' => [
        'repository' => env('LIBRARY_REPOSITORY_URL'),
        'ejournal' => env('LIBRARY_EJOURNAL_URL'),
    ],

    /*
    | Daftar CJS per program studi. Isi dengan pasangan nama prodi dan URL,
    | contoh: ['name' => 'Teknik Informatika', 'url' => 'https://...'].
    */
    'cjs' => [
        // ['name' => 'Teknik Informatika', 'url' => 'https://...'],
    ],

];
