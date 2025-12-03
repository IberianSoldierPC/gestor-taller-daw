<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tool;
use App\Models\User;

class ToolSeeder extends Seeder
{
    // Crea herramientas de ejemplo y las asigna al usuario administrador.
    public function run()
    {

        $admin = User::where('email', 'admin@taller.test')->first();

        if (!$admin) {
            echo "ERROR: El usuario administrador 'admin@taller.test' no fue encontrado. Asegúrate de que AdminUserSeeder se ejecute antes.";
            return;
        }

        $adminId = $admin->id;

        $tools = [
            [
                'name' => 'Taladro percutor Bosch',
                'description' => 'Para perforar hormigón y metal.',
                'location' => 'Almacén A-1',
                'status' => 'Disponible',
                'acquisition_date' => now()->subMonths(18),
                'user_id' => $adminId,
            ],
            [
                'name' => 'Sierra de calar Makita',
                'description' => 'Cortes curvos y detallados en madera.',
                'location' => 'Banco de Trabajo #3',
                'status' => 'En uso',
                'acquisition_date' => now()->subMonths(5),
                'user_id' => $adminId,
            ],
            [
                'name' => 'Prensa de banco pesada',
                'description' => 'Sujeción firme de piezas grandes.',
                'location' => 'Almacén A-2',
                'status' => 'Mantenimiento',
                'acquisition_date' => now()->subYears(3),
                'user_id' => $adminId,
            ],
            [
                'name' => 'Soldador TIG (Fronius)',
                'description' => 'Soldadura fina de precisión en metales no ferrosos.',
                'location' => 'Cabina de Soldadura #1',
                'status' => 'Disponible',
                'acquisition_date' => now()->subMonths(1),
                'user_id' => $adminId,
            ],
            [
                'name' => 'Nivel láser Hilti',
                'description' => 'Proyección de líneas de referencia autonivelante.',
                'location' => 'Caja de Herramientas G',
                'status' => 'Disponible',
                'acquisition_date' => now()->subMonths(12),
                'user_id' => $adminId,
            ],
        ];

        foreach ($tools as $tool) {
            // Usamos updateOrCreate buscando por el nombre para evitar duplicados en cada ejecución.
            Tool::updateOrCreate(['name' => $tool['name']], $tool);
        }
    }
}
