<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View; // Importar View

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $totalTools = Tool::count();
        $availableTools = Tool::where('status', 'Operativa')->count();
        $loanedTools = Tool::where('status', 'Prestada')->count();
        $brokenTools = Tool::whereIn('status', ['Averiada', 'Mantenimiento'])->count();

        if ($user->role === 'admin') {
            $tools = Tool::with('user')->get();
        } else {
            $tools = Tool::where('user_id', $user->id)->with('user')->get();
        }
        return view('dashboard.index', [
            'totalTools' => $totalTools,
            'availableTools' => $availableTools,
            'loanedTools' => $loanedTools,
            'brokenTools' => $brokenTools,
            'tools' => $tools,
        ]);
    }
}
