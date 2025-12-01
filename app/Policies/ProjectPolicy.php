<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;

class ProjectPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }
        return null;
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function view(User $user, Project $project): bool
    {
        return $project->assigned_to_user_id === $user->id;
    }

    public function update(User $user, Project $project): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->role === 'admin';
    }
}
