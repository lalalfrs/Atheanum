<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LibraryEventController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Athenaeum Library System
|--------------------------------------------------------------------------
*/

// Autentikasi
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Beranda & halaman informasi publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::controller(PageController::class)->group(function () {
    Route::get('/tentang-kami', 'about')->name('pages.about');
    Route::get('/kontak', 'contact')->name('pages.contact');
    Route::get('/pustakawan', 'librarians')->name('pages.librarians');
    Route::get('/bantuan', 'help')->name('pages.help');
    Route::get('/cjs', 'cjs')->name('cjs.index');
});

// Dashboard katalog
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Books Resource & Catalog CRUD
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
Route::post('/books', [BookController::class, 'store'])->name('books.store');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
Route::match(['put', 'patch'], '/books/{book}', [BookController::class, 'update'])->name('books.update');
Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
Route::post('/books/{book}/stock', [BookController::class, 'updateStock'])->name('books.stock');

// Data Export Routes
Route::get('/export/csv', [BookController::class, 'exportCsv'])->name('books.export.csv');
Route::get('/export/sql', [BookController::class, 'exportSql'])->name('books.export.sql');

// Categories / DDC Classification
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

// Physical Shelf Inventory Report
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');

// E-Book & Koleksi Digital (Tersedia untuk Pengunjung / Mahasiswa)
Route::get('/ebooks', [EbookController::class, 'index'])->name('ebooks.index');
Route::get('/ebooks/{book}', [EbookController::class, 'read'])->name('ebooks.show');
Route::get('/ebooks/{book}/read', [EbookController::class, 'read'])->name('ebooks.read');

// Rute Terproteksi Pengguna Terautentikasi
Route::middleware('auth')->group(function () {
    // Layanan Peminjaman Buku Fisik & Sirkulasi
    Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
    Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
    Route::post('/loans/{loan}/return', [LoanController::class, 'returnBook'])->name('loans.return');
    Route::post('/loans/{loan}/renew', [LoanController::class, 'renew'])->name('loans.renew');
    Route::post('/loans/{loan}/pay-fine', [LoanController::class, 'payFine'])->name('loans.payFine');

    // Manajemen Pengguna & Promosi Hak Akses (Khusus Super Admin)
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/role', [UserManagementController::class, 'updateRole'])->name('users.role');

    // Pengelolaan berita & acara (khusus pustakawan, dicek di controller/request).
    // Didaftarkan sebelum rute {slug} publik agar "tulis" dan "tambah" tidak dianggap slug.
    Route::get('/berita/tulis', [NewsController::class, 'create'])->name('news.create');
    Route::post('/berita', [NewsController::class, 'store'])->name('news.store');
    Route::delete('/berita/{news}', [NewsController::class, 'destroy'])->name('news.destroy');

    Route::get('/acara/tambah', [LibraryEventController::class, 'create'])->name('events.create');
    Route::post('/acara', [LibraryEventController::class, 'store'])->name('events.store');
    Route::delete('/acara/{event}', [LibraryEventController::class, 'destroy'])->name('events.destroy');
});

// Berita & acara (publik)
Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita/{news}', [NewsController::class, 'show'])->name('news.show');
Route::get('/acara', [LibraryEventController::class, 'index'])->name('events.index');
Route::get('/acara/{event}', [LibraryEventController::class, 'show'])->name('events.show');

// Settings & Diagnostic
Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
Route::post('/settings/reset', [SettingsController::class, 'resetDatabase'])->name('settings.reset');
