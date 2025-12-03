<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\ProjectController;
use App\Models\Tool;
const PROFILE_PATH = '/profile';
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminUserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    $metricsBase = ($user && $user->role === 'admin') ? Tool::query() : Tool::where('user_id', optional($user)->id);
    $totalTools     = (clone $metricsBase)->count();
    $availableTools = (clone $metricsBase)->where('status', 'Disponible')->count();
    $inUseTools     = (clone $metricsBase)->where('status', 'En uso')->count();
    $maintenanceTools = (clone $metricsBase)->where('status', 'Mantenimiento')->count();
    $tools = ($user && $user->role === 'admin')
        ? Tool::with('user')->orderBy('name')->get()
        : Tool::where('user_id', optional($user)->id)->with('user')->orderBy('name')->get();

    // Métricas de proyectos (resumen) por rol
    $projectsBase = ($user && $user->role === 'admin')
        ? \App\Models\Project::query()
        : \App\Models\Project::where('assigned_to_user_id', optional($user)->id);
    $totalProjects = (clone $projectsBase)->count();
    $inProgressProjects = (clone $projectsBase)->where('status', 'En proceso')->count();
    $completedProjects = (clone $projectsBase)->where('status', 'Terminado')->count();
    // Métrica de urgentes por usuario/rol
    $urgentProjects = (clone $projectsBase)->where('status', 'Urgente')->count();

    return view('dashboard', compact(
        'totalTools', 'availableTools', 'inUseTools', 'maintenanceTools', 'tools',
        'totalProjects', 'inProgressProjects', 'completedProjects', 'urgentProjects'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get(PROFILE_PATH, [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch(PROFILE_PATH, [ProfileController::class, 'update'])->name('profile.update');
    Route::delete(PROFILE_PATH, [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('tools', ToolController::class);
    Route::resource('projects', ProjectController::class);

    // Admin: gestión de usuarios (protección en el controlador)
    // Prefijo y nombre para admin: URLs /admin/users y nombres admin.users.*
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', AdminUserController::class)->only(['index','edit','update','destroy']);
    });
});
// Cargar rutas de autenticación (mantener require_once para evitar múltiples inclusiones)
require_once __DIR__.'/auth.php';
