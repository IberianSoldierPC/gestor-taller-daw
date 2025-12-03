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

        // Filtros: nombre y estado
        if ($search = trim((string) $request->query('q'))) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $statuses = Tool::statusOptions();

        if (($status = trim((string) $request->query('status'))) && in_array($status, $statuses, true)) {
            $query->where('status', $status);
        }

        // Filtro por usuario asignado (solo admin)
        if ($user->role === 'admin' && ($userId = $request->query('user_id'))) {
            $query->where('user_id', $userId);
        }

        $sort = trim((string) $request->query('sort'));
        if ($sort === 'alpha') {
            $query->orderBy('name', 'asc');
        } else {
            // default: latest created first
            $query->orderBy('created_at', 'desc');
        }

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        $tools = $query->paginate(10)->withQueryString();

        // Métricas por rol: admin ve global, usuario ve solo las suyas
        $metricsBase = ($user->role === 'admin') ? Tool::query() : Tool::where('user_id', $user->id);
        $totalTools = (clone $metricsBase)->count();
        $availableTools = (clone $metricsBase)->where('status', 'Disponible')->count();
        $inUseTools = (clone $metricsBase)->where('status', 'En uso')->count();
        $maintenanceTools = (clone $metricsBase)->where('status', 'Mantenimiento')->count();
        $users = ($user->role === 'admin') ? User::orderBy('name')->get(['id','name']) : collect();
        return view('tools.index', compact('tools', 'totalTools', 'availableTools', 'inUseTools', 'maintenanceTools', 'statuses', 'users'));
    }

    public function create(): View
    {
        $this->authorize('create', Tool::class);
        $users = Auth::user()->role === 'admin' ? User::orderBy('name')->get(['id', 'name']) : collect();
        return view('tools.create', [
            'users' => $users,
            'statuses' => Tool::statusOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Tool::class);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            // Estados permitidos
            'status' => 'required|in:' . implode(',', Tool::STATUSES),
            'acquisition_date' => 'required|date',
            // Para admin se permite seleccionar usuario; para usuarios se asigna automáticamente
            'user_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
        ]);

        // Asignación automática para usuarios no administradores
        $user = Auth::user();
        if ($user->role !== 'admin') {
            // Usuarios no admin: se autoasigna al creador
            $validatedData['user_id'] = $user->id;
        } // Admin: permitir crear sin asignar (nullable)

        Tool::create($validatedData);

        return redirect()->route('tools.index')->with('status', 'Herramienta creada con éxito.');
    }

    public function show(string $id)
    {
        // No utilizado
    }

    public function edit(string $id): View
    {
        $tool = Tool::findOrFail($id);
        $this->authorize('update', $tool);
        $users = Auth::user()->role === 'admin' ? User::orderBy('name')->get(['id', 'name']) : collect();
        return view('tools.edit', [
            'tool' => $tool,
            'users' => $users,
            'statuses' => Tool::statusOptions(),
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $tool = Tool::findOrFail($id);
        $this->authorize('update', $tool);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            // Estados permitidos
            'status' => 'required|in:' . implode(',', Tool::STATUSES),
            'acquisition_date' => 'required|date',
            // Solo admin puede cambiar el usuario asignado
            'user_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
        ]);
        // Para no admin, mantener propietario actual
        $user = Auth::user();
        if ($user->role !== 'admin') {
            // Usuarios no admin: mantener el propietario actual
            $validatedData['user_id'] = $tool->user_id;
        } // Admin: permitir dejar sin asignar (nullable)

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
