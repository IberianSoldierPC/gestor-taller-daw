<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\ProjectController; // <-- 1. ¡Importar el nuevo controlador!
use App\Models\Tool;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // Conteos básicos — ajusta los where() según tu esquema de base de datos
    $totalTools     = Tool::count();
    // Usar los mismos valores de estado que usa ToolController y las migraciones/seeder
    $availableTools = Tool::where('status', 'Operativa')->orWhere('status', 'Disponible')->count();
    $loanedTools    = Tool::where('status', 'Prestada')->orWhere('status', 'En Uso')->count();
    $brokenTools    = Tool::whereIn('status', ['Averiada', 'Mantenimiento', 'Rota'])->count();

    // Obtener listado de herramientas con el usuario asignado para el listado
    $tools = Tool::with('user')->orderBy('name')->get();

    return view('dashboard', compact('totalTools', 'availableTools', 'loanedTools', 'brokenTools', 'tools'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rutas del Módulo de Herramientas
    Route::resource('tools', ToolController::class);
    
    // Rutas del Módulo de Proyectos
    Route::resource('projects', ProjectController::class);
});
 
require_once __DIR__.'/auth.php';
