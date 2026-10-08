<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Artisan;

class SettingsController extends Controller
{
    /**
     * Display settings and system diagnostic overview.
     */
    public function index()
    {
        $systemInfo = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'database_driver' => config('database.default'),
            'total_books' => Book::count(),
            'total_categories' => Category::count(),
            'storage_linked' => file_exists(public_path('storage')),
            'environment' => config('app.env'),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'PHP CLI / Built-in Server',
        ];

        return view('settings.index', compact('systemInfo'));
    }

    /**
     * Reset database to initial seed data using Artisan.
     */
    public function resetDatabase()
    {
        try {
            Artisan::call('migrate:fresh', [
                '--seed' => true,
                '--force' => true,
            ]);

            return redirect()->route('settings.index')
                ->with('success', 'Database berhasil direset kembali ke data awal bawaan katalog.');
        } catch (\Exception $e) {
            return redirect()->route('settings.index')
                ->with('error', 'Gagal mereset database: '.$e->getMessage());
        }
    }
}
