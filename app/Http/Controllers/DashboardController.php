<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View; // Tipo de retorno de la vista

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        // Métricas por rol: admin ve global, usuario ve solo las suyas
        $metricsBase = ($user->role === 'admin') ? Tool::query() : Tool::where('user_id', $user->id);
        $totalTools = (clone $metricsBase)->count();
        $availableTools = (clone $metricsBase)->where('status', 'Disponible')->count();
        $inUseTools = (clone $metricsBase)->where('status', 'En uso')->count();
        $maintenanceTools = (clone $metricsBase)->where('status', 'Mantenimiento')->count();

        $tools = ($user->role === 'admin')
            ? Tool::with('user')->get()
            : Tool::where('user_id', $user->id)->with('user')->get();
        return view('dashboard', [
            'totalTools' => $totalTools,
            'availableTools' => $availableTools,
            'inUseTools' => $inUseTools,
            'maintenanceTools' => $maintenanceTools,
            'tools' => $tools,
        ]);
    }
}
