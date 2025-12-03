<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    const EN_USO = 'En uso';
    const MANTENIMIENTO = 'Mantenimiento';
    const DISPONIBLE = 'Disponible';

    public function up(): void
    {
        $map = [
            'En Uso' => self::EN_USO,
            'Operativa' => self::DISPONIBLE,
            'Prestada' => self::EN_USO,
            'Averiada' => self::MANTENIMIENTO,
            'Rota' => self::MANTENIMIENTO,
            'En Mantenimiento' => self::MANTENIMIENTO,
        ];

        foreach ($map as $from => $to) {
            DB::table('tools')->where('status', $from)->update(['status' => $to]);
        }
    }

    public function down(): void
    {
        DB::table('tools')->where('status', self::EN_USO)->update(['status' => 'En Uso']);
    }
};
