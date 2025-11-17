<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    /**
     * Determina si el usuario puede realizar cualquier acción (Admin Override).
     * Se ejecuta ANTES que cualquier otro método de Policy.
     */
    public function before(User $user, string $ability): bool|null
    {
        // El administrador puede hacer CUALQUIER COSA.
        if ($user->role === 'admin') {
            return true;
        }

        // Si no es admin, continua con los métodos específicos de la Policy.
        return null;
    }

    /**
     * Determina si el usuario puede crear modelos.
     * Solo permite al admin (gracias al método before).
     */
    public function create(User $user): bool
    {
        // Esta comprobación es redundante si before() existe,
        // pero se mantiene por claridad de lo que debería hacer este método.
        return $user->role === 'admin';
    }

    /**
     * Determina si el usuario puede ver el modelo.
     * Un empleado solo puede ver los proyectos que le han sido asignados.
     */
    public function view(User $user, Project $project): bool
    {
        // El admin ya es autorizado por before().
        // El empleado solo puede ver si es el asignado.
        return $project->assigned_to_user_id === $user->id;
    }

    /**
     * Determina si el usuario puede actualizar el modelo.
     * Solo permite al admin (gracias al método before).
     */
    public function update(User $user, Project $project): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determina si el usuario puede eliminar el modelo.
     * Solo permite al admin (gracias al método before).
     */
    public function delete(User $user, Project $project): bool
    {
        return $user->role === 'admin';
    }
}
