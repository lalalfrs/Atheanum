<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Self Improvement',
                'slug' => 'self-improvement',
                'ddc_code' => '158.1',
                'color' => '#15803d',
                'description' => 'Pengembangan diri, pembentukan kebiasaan positif, dan motivasi produktivitas.',
            ],
            [
                'name' => 'Filsafat',
                'slug' => 'filsafat',
                'ddc_code' => '100',
                'color' => '#1f6c3a',
                'description' => 'Filsafat klasik, stoikisme modern, dialektika, dan etika pemikiran rasional.',
            ],
            [
                'name' => 'Teknologi & Komputer',
                'slug' => 'teknologi-komputer',
                'ddc_code' => '005.1',
                'color' => '#00652c',
                'description' => 'Software architecture, rekayasa perangkat lunak, database, dan sistem informasi.',
            ],
            [
                'name' => 'Fiksi & Sastra',
                'slug' => 'fiksi-sastra',
                'ddc_code' => '813',
                'color' => '#24703e',
                'description' => 'Novel sastra Indonesia & dunia, roman sejarah, dan karya prosa inspiratif.',
            ],
            [
                'name' => 'Referensi & Umum',
                'slug' => 'referensi-umum',
                'ddc_code' => '020',
                'color' => '#4b5563',
                'description' => 'Buku ajar universitas, ensiklopedia referensi, dan dokumentasi akademik terapan.',
            ],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
