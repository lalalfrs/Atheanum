<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman formulir login pustakawan.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Tampilkan halaman formulir registrasi akun pustakawan baru.
     */
    public function showRegisterForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    /**
     * Proses pendaftaran akun pustakawan baru dengan token Laravel Sanctum.
     */
    public function register(RegisterRequest $request): JsonResponse|RedirectResponse
    {
        $user = User::create([
            'name' => $request->string('name')->trim(),
            'email' => $request->string('email')->trim()->lower(),
            'role' => 'member',
            'password' => Hash::make($request->string('password')),
        ]);

        // Masuk secara otomatis setelah pendaftaran akun baru
        Auth::login($user);

        // Terbitkan Personal Access Token menggunakan Laravel Sanctum
        $token = $user->createToken('athenaeum-session-token')->plainTextToken;

        // Regenerasi sesi web jika tersedia untuk mencegah Session Fixation
        if ($request->hasSession()) {
            $request->session()->regenerate();
            session(['sanctum_token' => $token]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Pendaftaran akun berhasil. Selamat datang di sistem, '.$user->name.'.',
                'token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'redirect_url' => route('dashboard'),
            ], 201);
        }

        return redirect()->route('dashboard')
            ->with('success', 'Pendaftaran akun pustakawan berhasil. Selamat bertugas, '.$user->name.'!');
    }

    /**
     * Proses autentikasi masuk dengan Laravel Sanctum.
     */
    public function login(LoginRequest $request): JsonResponse|RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Alamat surel atau kata sandi yang Anda masukkan tidak sesuai dengan catatan kami.',
                ], 422);
            }

            return back()
                ->withErrors([
                    'email' => 'Alamat surel atau kata sandi tidak cocok dengan data katalog pustakawan.',
                ])
                ->withInput($request->only('email', 'remember'));
        }

        /** @var User $user */
        $user = Auth::user();

        // Terbitkan Personal Access Token menggunakan Laravel Sanctum
        $token = $user->createToken('athenaeum-session-token')->plainTextToken;

        // Regenerasi sesi web jika tersedia untuk mencegah Session Fixation
        if ($request->hasSession()) {
            $request->session()->regenerate();
            session(['sanctum_token' => $token]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Autentikasi berhasil. Selamat datang kembali, '.$user->name.'.',
                'token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'redirect_url' => route('dashboard'),
            ]);
        }

        return redirect()->intended(route('dashboard'))
            ->with('success', 'Autentikasi Sanctum berhasil. Selamat bertugas, '.$user->name.'!');
    }

    /**
     * Proses keluar (logout) dari sistem dan cabut token Sanctum.
     */
    public function logout(Request $request): JsonResponse|RedirectResponse
    {
        /** @var User|null $user */
        $user = $request->user();

        if ($user) {
            // Hapus semua token Sanctum aktif milik pengguna
            $user->tokens()->delete();
        }

        Auth::guard('web')->logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Berhasil keluar dari sesi perpustakaan dan token Sanctum telah dicabut.',
            ]);
        }

        return redirect()->route('login')
            ->with('success', 'Sesi Anda telah diakhiri dan token autentikasi telah dicabut dengan aman.');
    }
}
