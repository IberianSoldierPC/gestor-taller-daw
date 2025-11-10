<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Crea un usuario Administrador y un usuario Empleado de prueba.
     *
     * @return void
     */
    public function run()
    {
        // 1. Usuario Administrador (Puede ver todos los proyectos)
        User::updateOrCreate(
            ['email' => 'admin@taller.test'],
            [
                'name' => 'Admin Taller Principal',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
        // 2. Usuario Empleado (Solo verá proyectos asignados a él)
        User::updateOrCreate(
            ['email'=> 'empleado@taller.test'],
            [
                'name' => 'Empleado Juan',
                'password' => Hash::make('password'),
                'role' => 'employee',
                'email_verified_at' => now(),
            ]
        );
        // 3. Crear 5 usuarios empleados aleatorios adicionales de fábrica
        User::factory(5)->create(['role' => 'employee']);
    }
}