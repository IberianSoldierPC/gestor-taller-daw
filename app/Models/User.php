<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ---------------- RELACIONES ----------------

    /**
     * Relación 1:N: Obtiene todas las herramientas asignadas al usuario.
     */
    public function tools(): HasMany
    {
        return $this->hasMany(Tool::class);
    }

    /**
     * Relación 1:N: Obtiene todos los proyectos asignados al usuario.
     */
    public function projects(): HasMany
    {
        // Clave foránea explícita 'assigned_to_user_id'
        return $this->hasMany(Project::class, 'assigned_to_user_id');
    }
}
