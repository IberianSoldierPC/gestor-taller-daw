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
     * Muestra un listado de los recursos (Proyectos).
     */
    public function index()
    {
        $user = Auth::user();

        // Lógica de roles: Administrador vs. Empleado
        if ($user->role === 'admin') {
            // El admin ve TODOS los proyectos, cargando la relación 'assignedTo' (el usuario asignado) y 'tools'
            $projects = Project::with('assignedTo', 'tools')->get(); 
        } else {
            // El empleado solo ve los proyectos que le han sido asignados
            $projects = Project::where('assigned_to_user_id', $user->id)
                               ->with('assignedTo', 'tools')->get();
        }

        return view('projects.index', compact('projects'));
    }

    /**
     * Muestra el formulario para crear un nuevo recurso. (Solo Admin)
     */
    public function create()
    {
        // CONTROL DE ACCESO: Solo Administradores pueden acceder a la creación.
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado. Solo administradores pueden crear proyectos.');
        }

        // 1. Obtener todos los usuarios para el selector "Asignado a"
        $users = User::orderBy('name')->get(['id', 'name']);
        
        // 2. Obtener todas las herramientas para la selección múltiple
        $tools = Tool::orderBy('name')->get(['id', 'name']);
        
        // 3. Pasamos la lista de usuarios y herramientas a la vista
        return view('projects.create', compact('users', 'tools'));
    }

    /**
     * Store a newly created resource in storage. (Solo Admin)
     */
    public function store(Request $request)
    {
        // CONTROL DE ACCESO: Solo Administradores pueden guardar proyectos.
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado. Solo administradores pueden guardar proyectos.');
        }
        
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
            $project->tools()->sync($request->input('tools'),[]);
        }

        // 4. Redirección con mensaje de éxito
        return redirect()->route('projects.index')->with('success', 'Proyecto "' . $project->name . '" creado con éxito.');
    }

    /**
     * Display the specified resource. (Todos pueden ver su proyecto o los del admin)
     */
    public function show(Project $project)
    {
        $user = Auth::user();

        // CONTROL DE ACCESO: Un empleado solo puede ver los proyectos que le han sido asignados.
        if ($user->role !== 'admin' && $project->assigned_to_user_id !== $user->id) {
            abort(403, 'Acceso denegado. Este proyecto no te ha sido asignado.');
        }

        $project->load('assignedTo', 'tools'); // Carga las relaciones necesarias
        return view('projects.show', compact('project')); // Pasa el proyecto a la vista
    }

    /**
     * Show the form for editing the specified resource. (Solo Admin)
     */
    public function edit(Project $project)
    {
        // CONTROL DE ACCESO: Solo Administradores pueden acceder a la edición.
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado. Solo administradores pueden editar proyectos.');
        }

        // Carga todas las herramientas disponibles para el select/checkboxes
        $tools = Tool::all();

        // Obtiene los IDs de las herramientas actualmente asociadas al proyecto
        // 'pluck' extrae una columna, 'toArray' lo convierte a array simple [1, 5, 8]
        $selectedToolIds = $project->tools()->pluck('tool_id')->toArray();
        
        // Obtener todos los usuarios para el selector "Asignado a"
        $users = User::orderBy('name')->get(['id', 'name']);

        // Retorna la vista de edición, pasando el proyecto, las herramientas, usuarios y los IDs seleccionados
        return view('projects.edit', compact('project', 'tools', 'selectedToolIds', 'users'));
    }

    /**
     * Update the specified resource in storage. (Solo Admin)
     */
    public function update(Request $request, Project $project)
    {
        // CONTROL DE ACCESO: Solo Administradores pueden actualizar proyectos.
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado. Solo administradores pueden actualizar proyectos.');
        }
        
        // 1. Validación de los datos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Pendiente,En Proceso,Terminado,En Espera de Piezas',
            'priority' => 'required|in:Baja,Media,Alta,Urgente',
            'due_date' => 'nullable|date',
            'assigned_to_user_id' => 'required|exists:users,id',
            'tools' => 'nullable|array',
            'tools.*' => 'exists:tools,id',
        ]);

        // 2. Actualización del registro principal
        $project->update($validatedData);

        // 3. Sincronización de la relación Many-to-Many
        $project->tools()->sync($request->input('tools', []));

        // 4. Redirección
        return redirect()->route('projects.index')
                             ->with('success', '¡Proyecto actualizado exitosamente!');
    }

    /**
     * Remove the specified resource from storage. (Solo Admin)
     */
    public function destroy(Project $project)
    {
        // CONTROL DE ACCESO: Solo Administradores pueden eliminar proyectos.
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado. Solo administradores pueden eliminar proyectos.');
        }
        
        // 1. Eliminamos el registro
        $projectname = $project->name; // Guardar el nombre antes de eliminar
        $project->delete();

        // 2. Redirigimos con mensaje de éxito
        return redirect()->route('projects.index') 
                             ->with('success', 'El proyecto "' . $projectname . '" ha sido eliminado correctamente.');
    }
}