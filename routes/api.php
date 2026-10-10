<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API Autentikasi untuk penerbitan token Laravel Sanctum
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Endpoint terproteksi Sanctum Bearer Token
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json([
            'user' => $request->user(),
            'message' => 'Profil pengguna terverifikasi melalui Laravel Sanctum token.',
        ]);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});
