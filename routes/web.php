<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LaravelStudioController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Athenaeum Library System
|--------------------------------------------------------------------------
*/

// Dashboard & Landing Showcase
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::view('/welcome', 'welcome')->name('welcome');

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

// Laravel & Eloquent Architecture Studio
Route::get('/laravel-studio', [LaravelStudioController::class, 'index'])->name('laravel-studio.index');
Route::post('/laravel-studio/query', [LaravelStudioController::class, 'runQuery'])->name('laravel-studio.query');

// Settings & Diagnostic
Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
Route::post('/settings/reset', [SettingsController::class, 'resetDatabase'])->name('settings.reset');
