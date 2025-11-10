<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $user = Auth::user();

        // Si el usuario es 'admin', obtiene todas las herramientas.
        if ($user->role === 'admin') {
            $tools = Tool::all();
        } else {
            // Si no es admin, solo obtiene las herramientas donde el user_id coincide con el ID del usuario logueado.
            $tools = Tool::where('user_id', $user->id)->get();
        }

        // Devolver la vista 'tools.index' y pasarle las herramientas.
        return view('tools.index', compact('tools'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = \App\Models\User::orderBy('name')->get(['id', 'name']);
        return view('tools.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
        // Se utiliza el método create que ya funciona con $fillable
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
    public function edit(string $id)
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
    public function update(Request $request, string $id)
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
    public function destroy(string $id)
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
