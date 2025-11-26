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
    $availableTools = Tool::where('status', 'available')->count(); // o ->where('is_available', true)
    $loanedTools    = Tool::where('status', 'loaned')->count();    // o ->whereNotNull('loaned_to')
    $brokenTools    = Tool::where('status', 'broken')->count();    // o ->where('condition','broken')

    return view('dashboard', compact('totalTools', 'availableTools', 'loanedTools', 'brokenTools'));
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

require __DIR__.'/auth.php';
