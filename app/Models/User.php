<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi riwayat peminjaman buku oleh pengguna.
     */
    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Cek apakah pengguna adalah Super Admin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin' || in_array(strtolower($this->email), [
            'librarian@athenaeum.test',
            'librarian@atheanum.test',
        ]);
    }

    /**
     * Cek apakah pengguna adalah staf pustakawan (atau super admin).
     */
    public function isLibrarian(): bool
    {
        return $this->isSuperAdmin() || $this->role === 'librarian';
    }

    /**
     * Cek apakah pengguna adalah anggota biasa (pengunjung / mahasiswa).
     */
    public function isMember(): bool
    {
        return ! $this->isLibrarian();
    }
}
