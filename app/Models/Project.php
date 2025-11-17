<?php

namespace App\Models;

// app/Models/Project.php
use Illuminate\Database\Eloquent\Model;
use App\Models\User;    // Necesario para la relación 1:N
use App\Models\Tool;    // Necesario para la relación N:M

class Project extends Model
{
    // Campos que se rellenan desde un formulario
    protected $fillable = [
        'name', 'description', 'status', 'priority', 'assigned_to_user_id'
    ];
    
    // 1. Relación: Un Proyecto está asignado a UN Usuario (1:N)
    public function assignedTo()
    {
        // Le decimos a Laravel que use la clave foránea 'assigned_to_user_id'
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    // 2. Relación: Un Proyecto necesita MUCHAS Herramientas (N:M)
    public function tools()
    {
        return $this->belongsToMany(Tool::class);
    }
}
