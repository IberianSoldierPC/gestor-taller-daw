<?php

namespace App\Policies;

use App\Models\Tool;
use App\Models\User;

class ToolPolicy
{
    public function before(User $user): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->id !== null;
    }

    public function view(User $user, Tool $tool): bool
    {
        return $tool->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        // Cualquier usuario autenticado puede crear herramientas
        return $user->id !== null;
    }

    public function update(User $user, Tool $tool): bool
    {
        // Admin o propietario puede editar
        return $user->role === 'admin' || $tool->user_id === $user->id;
    }

    public function delete(User $user, Tool $tool): bool
    {
        // Admin o propietario
        return $user->role === 'admin' || $tool->user_id === $user->id;
    }
}
