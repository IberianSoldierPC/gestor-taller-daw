<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tool;
use App\Models\User; // Necesario para obtener el ID del Admin

class ToolSeeder extends Seeder
{
    /**
     * Crea herramientas de ejemplo con todos los campos requeridos.
     *
     * @return void
     */
    public function run()
    {
        // Buscamos al usuario administrador para asegurarnos de que existe.
        $admin = User::where('email', 'admin@taller.test')->first();

        // Comprobación de seguridad: Si no encontramos al Admin, detenemos el seeder.
        // Esto previene un error si AdminUserSeeder falló o no se ejecutó.
        if (!$admin) {
            // Muestra un mensaje de error útil si falla la dependencia.
            echo "ERROR: El usuario administrador 'admin@taller.test' no fue encontrado. Asegúrate de que AdminUserSeeder se ejecute antes.";
            return;
        }

        $adminId = $admin->id;

        $tools = [
            [
                'name' => 'Taladro Percutor Bosch',
                'description' => 'Para perforar hormigón y metal.',
                'location' => 'Almacén A-1',
                'status' => 'Disponible',
                'acquisition_date' => now()->subMonths(18),
                'user_id' => $adminId,
            ],
            [
                'name' => 'Sierra de Calar Makita',
                'description' => 'Cortes curvos y detallados en madera.',
                'location' => 'Banco de Trabajo #3',
                'status' => 'En Uso',
                'acquisition_date' => now()->subMonths(5),
                'user_id' => $adminId,
            ],
            [
                'name' => 'Prensa de Banco Pesada',
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
                'name' => 'Nivel Láser Hilti',
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
