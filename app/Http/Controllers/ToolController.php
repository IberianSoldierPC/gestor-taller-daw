<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ToolController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): View
    {
        $user = Auth::user();

        $query = Tool::with('user');

        // Filtros: búsqueda por nombre y estado
        if ($search = trim((string) $request->query('q'))) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($status = trim((string) $request->query('status'))) {
            $query->where('status', $status);
        }

        // Filtro por usuario asignado (solo visible para admin)
        if ($user->role === 'admin' && ($userId = $request->query('user_id'))) {
            $query->where('user_id', $userId);
        }

        $query->orderBy('name', 'asc');

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        $tools = $query->paginate(10)->withQueryString();

        $totalTools = Tool::count();
        $availableTools = Tool::whereIn('status', ['Operativa', 'Disponible'])->count();
        $loanedTools = Tool::whereIn('status', ['Prestada', 'En Uso'])->count();
        $brokenTools = Tool::whereIn('status', ['Averiada', 'Mantenimiento', 'Rota'])->count();

        $statuses = ['Operativa','Disponible','Prestada','En Uso','Averiada','Mantenimiento','Rota'];
        $users = ($user->role === 'admin') ? User::orderBy('name')->get(['id','name']) : collect();
        return view('tools.index', compact('tools', 'totalTools', 'availableTools', 'loanedTools', 'brokenTools', 'statuses', 'users'));
    }

    public function create(): View
    {
        $this->authorize('create', Tool::class);
        $users = User::orderBy('name')->get(['id', 'name']);
        return view('tools.create', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Tool::class);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            // Aceptar todos los estados usados en el sistema/vistas/seeders
            'status' => 'required|in:Operativa,Disponible,Averiada,Prestada,En Uso,Mantenimiento,Rota',
            'acquisition_date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
        ]);

        Tool::create($validatedData);

        return redirect()->route('tools.index')->with('status', 'Herramienta creada con éxito.');
    }

    public function show(string $id)
    {
        // No utilizado en este módulo
    }

    public function edit(string $id): View
    {
        $tool = Tool::findOrFail($id);
        $this->authorize('update', $tool);
        $users = User::orderBy('name')->get(['id', 'name']);
        return view('tools.edit', compact('tool', 'users'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $tool = Tool::findOrFail($id);
        $this->authorize('update', $tool);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            // Aceptar todos los estados usados en el sistema/vistas/seeders
            'status' => 'required|in:Operativa,Disponible,Averiada,Prestada,En Uso,Mantenimiento,Rota',
            'acquisition_date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
        ]);

        $tool->update($validatedData);

        return redirect()->route('tools.index')->with('status', 'Herramienta actualizada con éxito.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $tool = Tool::findOrFail($id);
        $this->authorize('delete', $tool);

        $toolName = $tool->name;
        $tool->delete();

        return redirect()->route('tools.index')
                             ->with('status', 'Herramienta "' . $toolName . '" eliminada correctamente.');
    }
}
