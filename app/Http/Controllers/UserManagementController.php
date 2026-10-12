<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    /**
     * Tampilkan daftar seluruh pengguna dan peran mereka.
     */
    public function index(Request $request): View
    {
        /** @var User|null $currentUser */
        $currentUser = $request->user();

        if (! $currentUser || ! $currentUser->isSuperAdmin()) {
            abort(403, 'Akses terbatas: Hanya Super Admin (Pustakawan Kepala) yang dapat mengelola pengguna.');
        }

        $query = User::withCount(['loans as active_loans_count' => function ($q) {
            $q->where('status', 'dipinjam');
        }]);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role = $request->input('role')) {
            $query->where('role', $role);
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total' => User::count(),
            'superadmin' => User::where('role', 'superadmin')->count(),
            'librarian' => User::where('role', 'librarian')->count(),
            'member' => User::where('role', 'member')->count(),
        ];

        return view('users.index', compact('users', 'stats'));
    }

    /**
     * Ubah hak akses / promosikan peran pengguna.
     */
    public function updateRole(Request $request, User $user): RedirectResponse
    {
        /** @var User|null $currentUser */
        $currentUser = $request->user();

        if (! $currentUser || ! $currentUser->isSuperAdmin()) {
            abort(403, 'Akses terbatas: Hanya Super Admin yang berwenang mengubah peran pengguna.');
        }

        $validated = $request->validate([
            'role' => ['required', 'string', 'in:superadmin,librarian,member'],
        ]);

        // Lindungi akun Super Admin utama agar tidak terkunci
        if (in_array(strtolower($user->email), User::SUPER_ADMIN_EMAILS, true) && $validated['role'] !== 'superadmin') {
            return back()->with('error', 'Akun Super Admin sistem tidak dapat diturunkan statusnya.');
        }

        $user->update(['role' => $validated['role']]);

        $roleLabels = [
            'superadmin' => 'Super Admin',
            'librarian' => 'Pustakawan Staf',
            'member' => 'Anggota (Pengunjung / Mahasiswa)',
        ];

        return back()->with('success', "Peran pengguna {$user->name} berhasil diperbarui menjadi {$roleLabels[$validated['role']]}.");
    }
}
