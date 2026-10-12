<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Jalankan database seeds untuk akun pengguna pustakawan dan anggota perpustakaan.
     */
    public function run(): void
    {
        // 1. Super Admin Utama (Pustakawan Kepala)
        User::updateOrCreate(
            ['email' => 'librarian@athenaeum.test'],
            [
                'name' => 'Dimas Prakoso',
                'role' => 'superadmin',
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );

        // Alias penulisan alternatif sesuai instruksi prompt
        User::updateOrCreate(
            ['email' => 'librarian@atheanum.test'],
            [
                'name' => 'Dimas Prakoso (Super Admin)',
                'role' => 'superadmin',
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );

        // 2. Anggota Pengunjung / Mahasiswa
        User::updateOrCreate(
            ['email' => 'mahasiswa@athenaeum.test'],
            [
                'name' => 'Ahmad Fauzi (Mahasiswa)',
                'role' => 'member',
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );
    }
}
