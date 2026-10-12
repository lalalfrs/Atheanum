<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

#[Fillable(['visitor_hash', 'visited_on'])]
class SiteVisit extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'visited_on' => 'string',
        ];
    }

    /**
     * Catat satu kunjungan unik per pengunjung per hari.
     * IP + user agent di-hash agar tidak menyimpan data pribadi mentah.
     * Menggunakan insertOrIgnore agar aman dari race condition, multi-tab, atau duplikasi tanpa menimbulkan 500 error.
     */
    public static function record(Request $request): void
    {
        try {
            $visitorHash = hash('sha256', (string) $request->ip().'|'.(string) $request->userAgent());
            $today = now()->format('Y-m-d');

            DB::table('site_visits')->insertOrIgnore([
                'visitor_hash' => $visitorHash,
                'visited_on' => $today,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable) {
            // Pelacakan analitik pengunjung tidak boleh merusak request utama pengunjung
        }
    }

    /**
     * @return array{today: int, month: int, total: int}
     */
    public static function summary(): array
    {
        try {
            $today = now()->format('Y-m-d');
            $startOfMonth = now()->startOfMonth()->format('Y-m-d');

            return [
                'today' => static::whereDate('visited_on', $today)->count(),
                'month' => static::whereDate('visited_on', '>=', $startOfMonth)
                    ->whereDate('visited_on', '<=', $today)
                    ->count(),
                'total' => static::count(),
            ];
        } catch (\Throwable) {
            return [
                'today' => 0,
                'month' => 0,
                'total' => 0,
            ];
        }
    }
}
