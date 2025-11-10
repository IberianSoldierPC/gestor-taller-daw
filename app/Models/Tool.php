<?php

namespace App\Models;

// app/Models/Tool.php
use Illuminate\Database\Eloquent\Model;
use App\Models\User;    // Necesario para la relación 1:N
use App\Models\Project; // Necesario para la relación N:M

class Tool extends Model
{
    // 1. El campo $fillable (Permiso): Le dice a Laravel que estos campos son seguros
    // para ser rellenados a la vez (por ejemplo, desde un formulario).
    protected $fillable = [
        'name', 'description', 'location', 'status', 'acquisition_date', 'user_id'
    ];
    // 1. El campo $casts: Convierte automáticamente el campo 'acquisition_date' a un objeto de fecha
    protected $casts = [
    'acquisition_date' => 'date',
    ];

    // 2. Relación: Una Herramienta pertenece a UN Usuario (1:N)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 3. Relación: Una Herramienta se usa en MUCHOS Proyectos (N:M)
    public function projects()
    {
        // belongsToMany usa la tabla pivote 'project_tool' automáticamente
        return $this->belongsToMany(Project::class);
    }
}