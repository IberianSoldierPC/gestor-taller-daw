<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\ProjectController;
use App\Models\Tool;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $totalTools     = Tool::count();
    $availableTools = Tool::where('status', 'Operativa')->orWhere('status', 'Disponible')->count();
    $loanedTools    = Tool::where('status', 'Prestada')->orWhere('status', 'En Uso')->count();
    $brokenTools    = Tool::whereIn('status', ['Averiada', 'Mantenimiento', 'Rota'])->count();
    $tools = Tool::with('user')->orderBy('name')->get();

    // Métricas de proyectos
    $totalProjects = \App\Models\Project::count();
    $inProgressProjects = \App\Models\Project::where('status', 'En proceso')->count();
    $completedProjects = \App\Models\Project::where('status', 'Terminado')->count();
    $blockedProjects = \App\Models\Project::whereIn('status', ['Bloqueado', 'En espera de piezas'])->count();

    return view('dashboard', compact(
        'totalTools', 'availableTools', 'loanedTools', 'brokenTools', 'tools',
        'totalProjects', 'inProgressProjects', 'completedProjects', 'blockedProjects'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('tools', ToolController::class);
    Route::resource('projects', ProjectController::class);
});
 
require_once __DIR__.'/auth.php';
