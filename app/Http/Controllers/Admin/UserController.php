<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $customersOnly = $request->boolean('customers');

        $users = User::query()
            ->when($customersOnly, fn ($query) => $query->where('is_admin', false))
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('id')
            ->get();

        return view('admin.users.index', [
            'users' => $users,
            'q' => $q,
            'customersOnly' => $customersOnly,
        ]);
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'is_admin' => ['required', 'boolean'],
        ]);

        if ((int) $user->id === (int) auth()->id()) {
            return back()->with('error', 'Tidak bisa mengubah role akun yang sedang dipakai.');
        }

        $user->update([
            'is_admin' => (bool) $validated['is_admin'],
        ]);

        return back()->with('success', 'Role user berhasil diperbarui.');
    }

    public function updateActive(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'is_active' => ['required', 'boolean'],
        ]);

        if ((int) $user->id === (int) auth()->id()) {
            return back()->with('error', 'Tidak bisa menonaktifkan akun yang sedang dipakai.');
        }

        $user->update([
            'is_active' => (bool) $validated['is_active'],
        ]);

        return back()->with('success', 'Status aktif user diperbarui.');
    }
}

