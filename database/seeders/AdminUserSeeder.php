<?php

// database/seeders/AdminUserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Esto evita duplicados y asegura que el usuario Admin exista.
        User::updateOrCreate(
            ['email' => 'admin@taller.test'],
            [
                'name' => 'Admin Taller Principal',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}