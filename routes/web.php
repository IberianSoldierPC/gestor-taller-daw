<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\ProjectController; // <-- 1. ¡Importar el nuevo controlador!
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
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
