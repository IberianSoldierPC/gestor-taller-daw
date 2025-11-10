<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id(); 
            $table->string('name', 150); 
            $table->text('description')->nullable();
            $table->enum('status', ['Pendiente', 'En Curso', 'En Espera de Piezas', 'Terminado'])->default('Pendiente');
            $table->enum('priority', ['Baja', 'Media', 'Alta'])->default('Media');
            $table->foreignId('assigned_to_user_id')->constrained('users')->onDelete('restrict'); 
            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
