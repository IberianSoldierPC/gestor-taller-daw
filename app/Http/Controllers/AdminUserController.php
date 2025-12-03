<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (!$user || $user->role !== 'admin') {
                abort(403);
            }
            return $next($request);
        });
    }

    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q'));
        $users = User::query()
            ->when($q !== '', fn($qb) => $qb->where('name','like',"%$q%")
                                             ->orWhere('email','like',"%$q%"))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:255',
            'role' => 'required|in:admin,employee',
        ]);
        $user->update($data);
        return redirect()->route('admin.users.index')->with('status', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user): RedirectResponse
    {
        // Evitar borrar al propio usuario autenticado
        if (Auth::id() === $user->id) {
            return redirect()->route('admin.users.index')->with('status', 'No puedes borrar tu propio usuario.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('status', 'Usuario eliminado correctamente.');
    }
}
