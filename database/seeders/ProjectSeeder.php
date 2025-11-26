<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\User;
use App\Models\Tool;

class ProjectSeeder extends Seeder
{
    // Crea proyectos de ejemplo y los asigna a usuarios y herramientas.

    public function run()
    {
        // Obtenemos los usuarios y herramientas necesarios
        $admin = User::where('email', 'admin@taller.test')->first();
        $employee = User::where('email', 'empleado@taller.test')->first();
        $allTools = Tool::all(); // Todas las herramientas

        if (!$admin || !$employee) {
            echo "Asegúrate de ejecutar AdminUserSeeder antes que ProjectSeeder.";
            return;
        }

        // --- 1. Proyectos Asignados al EMPLEADO (Debe verlos) ---
        $project1 = Project::create([
            'name' => 'Mesa de corte CNC',
            'description' => 'Construcción de una mesa de trabajo robusta para el router CNC.',
            'status' => 'En proceso',
            'priority' => 'Alta',
            'due_date' => now()->addDays(10),
            'assigned_to_user_id' => $employee->id,
        ]);
        $project1->tools()->attach($allTools->random(2)->pluck('id')); // Asignar 2 herramientas aleatorias

        $project2 = Project::create([
            'name' => 'Reparación de compresor',
            'description' => 'Diagnóstico y reparación de fugas en el compresor principal.',
            'status' => 'Pendiente',
            'priority' => 'Urgente',
            'due_date' => now()->addDays(2),
            'assigned_to_user_id' => $employee->id,
        ]);
        $project2->tools()->attach($allTools->random(1)->pluck('id')); // Asignar 1 herramienta aleatoria

        // --- 2. Proyectos Asignados al ADMIN (Visibles para Admin, INVISIBLES para Empleado) ---
        $project3 = Project::create([
            'name' => 'Reorganización del almacén',
            'description' => 'Inventario completo y reubicación de estanterías.',
            'status' => 'En espera de piezas',
            'priority' => 'Media',
            'due_date' => now()->addWeeks(3),
            'assigned_to_user_id' => $admin->id, // Asignado al Admin
        ]);
        $project3->tools()->attach($allTools->random(3)->pluck('id'));

        // --- 3. Proyecto Terminado (Visibles para Admin, INVISIBLES para Empleado si no está asignado a él) ---
        Project::create([
            'name' => 'Diseño de la app móvil',
            'description' => 'Fase de diseño UX/UI de la nueva aplicación de gestión.',
            'status' => 'Terminado',
            'priority' => 'Baja',
            'due_date' => now()->subDays(5),
            'assigned_to_user_id' => $admin->id,
        ]);
    }
}
