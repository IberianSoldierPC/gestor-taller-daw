<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View; // Importar View

class DashboardController extends Controller
{
    /**
     * Muestra la vista principal del Dashboard con estadísticas y listado de herramientas.
     */
    public function index(): View
    {
        $user = Auth::user();
        
        // 1. CÁLCULO DE LAS ESTADÍSTICAS DE HERRAMIENTAS
        // Total de todas las herramientas registradas
        $totalTools = Tool::count();
        
        // Herramientas disponibles (Estado: 'Operativa')
        $availableTools = Tool::where('status', 'Operativa')->count();
        
        // Herramientas prestadas/en uso (Estado: 'Prestada')
        $loanedTools = Tool::where('status', 'Prestada')->count();
        
        // Herramientas fuera de servicio (Estados: 'Averiada' o 'Mantenimiento')
        $brokenTools = Tool::whereIn('status', ['Averiada', 'Mantenimiento'])->count();

        // 2. OBTENER LISTADO DE HERRAMIENTAS (para la tabla inferior)
        // Se aplica la lógica de filtrado por rol. Se usa with('user') para Eager Loading.
        if ($user->role === 'admin') {
            // Admin ve todas las herramientas
            $tools = Tool::with('user')->get();
        } else {
            // Empleado ve solo sus herramientas asignadas
            $tools = Tool::where('user_id', $user->id)->with('user')->get();
        }
        
        // 3. PASAR LAS VARIABLES A LA VISTA
        return view('dashboard.index', [
            'totalTools' => $totalTools,
            'availableTools' => $availableTools,
            'loanedTools' => $loanedTools,
            'brokenTools' => $brokenTools,
            'tools' => $tools, // Añadido para que la tabla inferior funcione
        ]);
    }
}
