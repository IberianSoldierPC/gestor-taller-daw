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
    /**
     * Muestra la lista de herramientas, incluyendo estadísticas para la vista (tools.index).
     */
    public function index(): View
    {
        $user = Auth::user();

        // 1. Obtener listado de herramientas con Eager Loading (quién la tiene asignada)
        if ($user->role === 'admin') {
            $tools = Tool::with('user')->get();
        } else {
            $tools = Tool::where('user_id', $user->id)->with('user')->get();
        }

        // 2. CÁLCULO DE ESTADÍSTICAS (requeridas por tools.index.blade.php)
        $totalTools = Tool::count();
        $availableTools = Tool::where('status', 'Operativa')->count();
        $loanedTools = Tool::where('status', 'Prestada')->count();
        // Suma Averiada y cualquier otro estado que signifique fuera de servicio
        $brokenTools = Tool::whereIn('status', ['Averiada', 'Mantenimiento'])->count(); 
        
        // 3. Pasar todas las variables necesarias a la vista
        return view('tools.index', compact('tools', 'totalTools', 'availableTools', 'loanedTools', 'brokenTools'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // Llamada a \App\Models\User con el FQCN o importando User
        $users = User::orderBy('name')->get(['id', 'name']); 
        return view('tools.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validación de datos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'status' => 'required|in:Operativa,Averiada,Prestada',
            'acquisition_date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
        ]);

        // 2. Creación del recurso
        Tool::create($validatedData);

        // 3. Redirección con mensaje de éxito
        return redirect()->route('tools.index')->with('status', 'Herramienta creada con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        // Encuentra la herramienta por su ID o falla con 404
        $tool = Tool::findOrFail($id);
        
        // Obtiene todos los usuarios para el campo de asignación
        $users = User::orderBy('name')->get(['id', 'name']);

        // Carga la vista de edición con la herramienta y los usuarios
        return view('tools.edit', compact('tool', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        // 1. Encuentra la herramienta por su ID o falla con 404
        $tool = Tool::findOrFail($id);

        // 2. Validación de datos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'status' => 'required|in:Operativa,Averiada,Prestada',
            'acquisition_date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
        ]);

        // 3. Actualización del recurso
        $tool->update($validatedData);

        // 4. Redirección con mensaje de éxito
        return redirect()->route('tools.index')->with('status', 'Herramienta actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        // 1. Encontrar la herramienta. Si no existe, lanza un 404.
        $tool = Tool::findOrFail($id);

        // 2. Guardar el nombre antes de eliminar (para el mensaje de éxito)
        $toolName = $tool->name;

        // 3. ¡Eliminar la herramienta!
        $tool->delete();

        // 4. Redirigir a la lista con un mensaje de éxito.
        return redirect()->route('tools.index')
                         ->with('status', 'Herramienta "' . $toolName . '" eliminada correctamente.');
    }
}
