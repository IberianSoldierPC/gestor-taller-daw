<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'priority',
        'assigned_to_user_id',
        'due_date', // Correctamente añadido
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'date', // Correctamente añadido para conversión automática
    ];
    
    // ---------------- RELACIONES ----------------

    /**
     * Relación 1:N: Obtiene el usuario asignado a este proyecto.
     */
    public function assignedTo(): BelongsTo
    {
        // Se usa 'assigned_to_user_id' como clave foránea para evitar ambigüedades.
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    /**
     * Relación N:M: Obtiene todas las herramientas necesarias para el proyecto.
     */
    public function tools(): BelongsToMany
    {
        // belongsToMany utiliza la tabla pivot 'project_tool' por defecto.
        return $this->belongsToMany(Tool::class);
    }
}
