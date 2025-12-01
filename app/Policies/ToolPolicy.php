<?php

namespace App\Policies;

use App\Models\Tool;
use App\Models\User;

class ToolPolicy
{
    public function before(User $user, string $ability): bool|null
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
        return $user->role === 'admin';
    }

    public function update(User $user, Tool $tool): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Tool $tool): bool
    {
        return $user->role === 'admin';
    }
}
