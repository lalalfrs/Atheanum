<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryMap = Category::pluck('id', 'name')->toArray();

        $books = [
            [
                'title' => 'Atomic Habits',
                'subtitle' => 'Perubahan Kecil yang Memberikan Hasil Luar Biasa',
                'isbn' => '978-602-03-8591-4',
                'author' => 'James Clear',
                'publisher' => 'Gramedia Pustaka Utama',
                'category' => 'Self Improvement',
                'year' => 2021,
                'stock' => 24,
                'total_copies' => 24,
                'shelf_location' => 'Rak A-12',
                'status' => 'Tersedia',
                'cover_image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCFDBQosu4lBnJao3h9KL0iR0jVaOFwYEmC4mppJPQHCrc5yxG05H0N7sBros66J5zBYOC-FiqmFuzRsw0w0mtn2VkWbZbEzFMLPJqHBGgNgCUJ8sHcrPTh71b1iv37mr64OKd5KGkoIVI63ULdQWgogSYG58Pt8rrD_rv0X4uj4VBWHzKZ0Da4AOerXjRHXWZ0qV01zEMeEj4s7PyqeEv0Jy9l7tLWfFAycKUtsRZjmVA2mV5czPu1',
                'image_storage_path' => 'books/atomic_habits_cover.webp',
                'file_size_kb' => 48,
                'description' => 'Panduan definitif untuk menghentikan kebiasaan buruk dan membangun kebiasaan baik melalui sistem perbaikan 1% setiap hari.',
            ],
            [
                'title' => 'Filosofi Teras',
                'subtitle' => 'Panduan Hidup Tenang - Menjalani Hidup Stoic di Dunia Modern',
                'isbn' => '978-602-41-2518-9',
                'author' => 'Henry Manampiring',
                'publisher' => 'Penerbit Buku Kompas',
                'category' => 'Filsafat',
                'year' => 2019,
                'stock' => 2,
                'total_copies' => 12,
                'shelf_location' => 'Rak C-04',
                'status' => 'Stok Kritis',
                'cover_image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAylDzhS69C6c_wFZDHdgwm1Ypy31UFEHMxhTitS9DFZODJtje34dJmVbrMw7HQ53upC5KYfWXtzGBmv3uIQ7Kz51DKUA6sd6VnZ3LRN3e5C0gE44u-iMNjF5Z60NzFgg_9aMqZpZdpiz3fenEhI02YN71v2W-7CRI3lOKWL08iA_Zs2mM41ecOs7oKRwq9ftnFZF7yDF2zpidL9TtiRcioUFMJqQVs257UHMoQr1fe5nkgLziOjVCd',
                'image_storage_path' => 'books/filosofi_teras_cover.webp',
                'file_size_kb' => 52,
                'description' => 'Penerapan praktis filsafat Stoisisme kuno untuk mengatasi emosi negatif, kekhawatiran masa depan, dan mencapai ketenangan batin.',
            ],
            [
                'title' => 'Clean Architecture',
                'subtitle' => 'A Craftsman\'s Guide to Software Structure and Design',
                'isbn' => '978-013-44-9416-6',
                'author' => 'Robert C. Martin',
                'publisher' => 'Prentice Hall',
                'category' => 'Teknologi & Komputer',
                'year' => 2018,
                'stock' => 12,
                'total_copies' => 15,
                'shelf_location' => 'Rak T-01',
                'status' => 'Tersedia',
                'cover_image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBFGNT3XheiIYPlqxxSefMAz_14hOzFOGeEvZmIwpfN4tZ9H6dkBFmKMPqAwTEYpm97YTdnoV9FJ7ZVP4hpUfwH8zqJh6C2NXm6x08q0H-3ur5-NQO8BzexbmgTo_aABfX3ijppIgO_GoWZd_HCZszRMlGCyTtXw8h704MJHq6OX0r4djSjSj0lBmgwQBD9xhct1bdW0_95kJOv9h9YF3dkME8kjK0dxTSGiZoeokYQIdb_xMV0lNls',
                'image_storage_path' => 'books/clean_architecture_cover.webp',
                'file_size_kb' => 64,
                'description' => 'Pedoman arsitektur perangkat lunak modular, pemisahan dependensi (SOLID), dan perancangan sistem berbasis domain independen framework.',
            ],
            [
                'title' => 'Laskar Pelangi',
                'subtitle' => 'The Rainbow Troops - An Inspirational Novel',
                'isbn' => '978-979-30-6279-2',
                'author' => 'Andrea Hirata',
                'publisher' => 'Bentang Pustaka',
                'category' => 'Fiksi & Sastra',
                'year' => 2005,
                'stock' => 15,
                'total_copies' => 20,
                'shelf_location' => 'Rak B-08',
                'status' => 'Tersedia',
                'cover_image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBithebMUdUulLyhN5WrNVtvuyJ9pU7uDrz_Sdu0qeZvV4eFB-SRng3nMsx04M82pJz-rCXuAvwRc5lKaKIDjqHxWBOVWxbCk38sEo9Y6BSp6VBOXP7FtO26yIxzW1mqNwNYFQTEYPgDey2lQ7Vp4zCKmU-IgUBIm5Ctlh0j61D1_83bhZl3wS0TFiqa8pqhBJPj5HFG_i3BTQEsUyE7DJtWSa1oHyV0O4kMPtX8TrcINU2AMf98WLv',
                'image_storage_path' => 'books/laskar_pelangi_cover.webp',
                'file_size_kb' => 76,
                'description' => 'Kisah perjuangan sepuluh anak di Belitung Timur menuntut ilmu di tengah keterbatasan fasilitas sekolah Muhammadiyah yang nyaris ditutup.',
            ],
            [
                'title' => 'Bumi Manusia',
                'subtitle' => 'Tetralogi Buru Buku Kesatu',
                'isbn' => '978-979-97-3123-4',
                'author' => 'Pramoedya Ananta Toer',
                'publisher' => 'Lentera Dipantara',
                'category' => 'Fiksi & Sastra',
                'year' => 2010,
                'stock' => 5,
                'total_copies' => 8,
                'shelf_location' => 'Rak B-02',
                'status' => 'Tersedia',
                'cover_image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCZqqlKVL33hNY6rFRjetjfYG1qs5lE-dCmLHkGL2ZXyQFniqQlIWdW5PPFQUluQso6lrPu6ZAhg-zw31qsk9XzXo09wUpas8TLbIJ5vYGphNmHzNNz6DCeGOmMYerMQRXYlPpk5KNU_FpW1T8OG0YVrcnaSZ2m2vPuTM9YH9RgX_JL6QNEc_hUWY1sZL9sUg406IkCKE_tnIU1E6ZP_5upRnBwti4aswu8xVZuGAA_W_HIZQmUE2Cg',
                'image_storage_path' => 'books/bumi_manusia_cover.webp',
                'file_size_kb' => 55,
                'description' => 'Kisah Minke di era Hindia Belanda awal abad ke-20 dan pergulatan hak asasi serta cinta bersama Annelies di hadapan hukum kolonial.',
            ],
            [
                'title' => 'Pengantar Sistem Informasi',
                'subtitle' => 'Kerangka Konseptual dan Aplikasi Bisnis Modern',
                'isbn' => '978-979-01-5231-1',
                'author' => 'Gordon B. Davis',
                'publisher' => 'Penerbit Erlangga',
                'category' => 'Referensi & Umum',
                'year' => 2020,
                'stock' => 1,
                'total_copies' => 5,
                'shelf_location' => 'Rak D-15',
                'status' => 'Stok Kritis',
                'cover_image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAxr25631MOraMM8EMu_28k2aE-tBREKbSeKlIUQ_eyQCKe2DTdZ-W2ArJ6C88Cb0hpxz83NVHq8F_ZC2yTxH0xp_5R3B7UH_Eoo5pH33k4zOyYUlNt-pmtwnMiI7sA7GJD8amOOvcnSV7KjewEx-wxvjnMFlnu4BabdZvksKY0rJ4E9JmwDjH7VgDENOUscnRpxVPaIsmnTjWsEGlhsX29kO9TErb2ZFdS4dtOW3wtfq7nhkc4VL-9',
                'image_storage_path' => 'books/sistem_informasi_cover.webp',
                'file_size_kb' => 61,
                'description' => 'Buku teks standar universitas mengenai struktur pengolahan data, manajemen basis data relasional, dan integrasi enterprise information system.',
            ],
            [
                'title' => 'Madilog',
                'subtitle' => 'Materialisme, Dialektika, dan Logika',
                'isbn' => '978-602-16-0329-1',
                'author' => 'Tan Malaka',
                'publisher' => 'Narasi Pustaka',
                'category' => 'Filsafat',
                'year' => 2014,
                'stock' => 0,
                'total_copies' => 6,
                'shelf_location' => 'Rak C-01',
                'status' => 'Habis',
                'cover_image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDoOouWuo0xDp-J5kjSvEDPcThEmXZp9bBc_uJ6UEWcleF7oK4bKVZq7LFVH7eYZZleJLZ2h4-s5Et248CLV1z8OQdJFm53AyoovZAgD7ta5Bz2dS_Ky42eBuD54r23bBrIZo0GzjZvCn7LiLcyUj2Ahmzis3SyG_h2bwo3ezfPvo9liqsmtfmjTOzwvWlwLtrIGBCXp3ctHdy7mz35eGsa5hUogofs34DcVcAIHKLxcdaJjmBNSxpH',
                'image_storage_path' => 'books/madilog_cover.webp',
                'file_size_kb' => 49,
                'description' => 'Mahakarya pemikiran Tan Malaka mengenai cara berpikir ilmiah bangsa Indonesia guna membebaskan diri dari logika mistika.',
            ],
        ];

        foreach ($books as $data) {
            $catId = $categoryMap[$data['category']] ?? null;
            $data['category_id'] = $catId;
            Book::updateOrCreate(['isbn' => $data['isbn']], $data);
        }
    }
}
