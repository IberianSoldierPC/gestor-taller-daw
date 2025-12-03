<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;

class ProjectPolicy
{
    public function before(User $user): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }
        return null;
    }

    public function create(User $user): bool
    {
        // Cualquier usuario autenticado puede crear proyectos
        return $user->id !== null;
    }

    public function view(User $user, Project $project): bool
    {
        return $project->assigned_to_user_id === $user->id;
    }

    public function update(User $user, Project $project): bool
    {
        // Admin o responsable asignado puede editar
        return $user->role === 'admin' || $project->assigned_to_user_id === $user->id;
    }

    public function delete(User $user, Project $project): bool
    {
        // Admin o responsable asignado
        return $user->role === 'admin' || $project->assigned_to_user_id === $user->id;
    }
}
