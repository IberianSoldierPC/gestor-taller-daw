<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tool;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Lógica de roles: Administrador vs. Empleado
        if ($user->role === 'admin') {
            // El admin ve TODOS los proyectos, cargando el usuario asignado
            $projects = Project::with('assignedTo')->get(); 
        } else {
            // El empleado solo ve los proyectos que le han sido asignados
            $projects = Project::where('assigned_to_user_id', $user->id)
                                ->with('assignedTo')->get();
        }

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 1. Obtener todos los usuarios para el selector "Asignado a"
        $users = User::orderBy('name')->get(['id', 'name']);
        
        // 2. Obtener todas las herramientas para la selección múltiple
        $tools = \App\Models\Tool::orderBy('name')->get(['id', 'name']);
        
        // 3. Pasamos la lista de usuarios y herramientas a la vista
        return view('projects.create', compact('users', 'tools'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validación de datos
        $validatedData = $request->validate([
            'name' => 'required|string|max:150', // Coincide con el campo 'name' de la BBDD
            'description' => 'nullable|string',
            'status' => 'required|in:Pendiente,En Proceso,Terminado,En Espera de Piezas',
            'priority' => 'required|in:Baja,Media,Alta,Urgente',
            'due_date' => 'nullable|date',
            'assigned_to_user_id' => 'required|exists:users,id',
            
            // Validación para la relación N:M (tools es un array opcional)
            'tools' => 'nullable|array',
            'tools.*' => 'exists:tools,id',
        ]);

        // 2. Creación del Proyecto
        $project = Project::create($validatedData);
        
        // 3. Manejar la relación Muchos a Muchos (Tools)
        if (isset($validatedData['tools'])) {
            // El método attach() inserta las filas en la tabla pivot 'project_tool'
            $project->tools()->attach($validatedData['tools']);
        }

        // 4. Redirección con mensaje de éxito
        return redirect()->route('projects.index')->with('status', 'Proyecto "' . $project->name . '" creado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load('assignedTo', 'tools'); // Carga las relaciones necesarias
        return view('projects.show', compact('project')); // Pasa el proyecto a la vista
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        // Carga todas las herramientas disponibles para el select/checkboxes
        $tools = Tool::all();

        // Obtiene los IDs de las herramientas actualmente asociadas al proyecto
        // 'pluck' extrae una columna, 'toArray' lo convierte a array simple [1, 5, 8]
        $selectedToolIds = $project->tools()->pluck('tool_id')->toArray();

        // Retorna la vista de edición, pasando el proyecto, las herramientas y los IDs seleccionados
        return view('projects.edit', compact('project', 'tools', 'selectedToolIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        // 1. Validación de los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tools' => 'nullable|array',
            'tools.*' => 'exists:tools,id',
        ]);

        // 2. Actualización del registro principal
        $project->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // 3. Sincronización de la relación Many-to-Many
        $project->tools()->sync($request->input('tools', []));

        // 4. Redirección
        return redirect()->route('projects.index')
                         ->with('success', '¡Proyecto actualizado exitosamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        // 1. Eliminamos el registro
        $projectname = $project->name; // Guardar el nombre antes de eliminar
        $project->delete();

        // 2. Redirigimos con mensaje de éxito
        return redirect()->route('projects.index') 
                            ->with('status', 'El proyecto "' . $projectname . '" ha sido eliminado correctamente.');
    }
}
