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
            
            // Columnas requeridas por el seeder:
            $table->string('status', 30)->default('Pendiente');
            $table->string('priority', 20)->default('Media');
            // La columna que estaba causando el error:
            $table->dateTime('due_date')->nullable();
            
            // Asignación de usuario (nullable por si el usuario es eliminado)
            $table->foreignId('assigned_to_user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

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
