<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tool;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectController extends Controller
{

    public function index(): View
    {
        $user = Auth::user();

        // 1. Determinar la consulta base
        $query = Project::with('assignedTo', 'tools')->orderBy('name', 'asc');

        // 2. Aplicar filtro basado en el rol del usuario
        if ($user->role === 'admin') {
            $title = 'Todos los Proyectos del Taller';
        } else {
            // El empleado solo ve los proyectos que le han sido asignados
            $query->where('assigned_to_user_id', $user->id);
            $title = 'Mis Proyectos Asignados';
        }

        // 3. Aplicar paginación (ej. 10 elementos por página)
        $projects = $query->paginate(10);

        // 4. Calcular estadísticas de TODOS los proyectos (sin paginación) para las tarjetas
        $baseQuery = Project::with('assignedTo', 'tools');
        
        if ($user->role !== 'admin') {
            $baseQuery->where('assigned_to_user_id', $user->id);
        }

        $totalProjects = $baseQuery->count();
        $inProgressProjects = (clone $baseQuery)->where('status', 'En proceso')->count();
        $completedProjects = (clone $baseQuery)->where('status', 'Terminado')->count();
        $blockedProjects = (clone $baseQuery)->where('status', 'Bloqueado')->orWhere('status', 'En espera de piezas')->count();

        // 5. Cargar la lista de herramientas (como lista de referencia, no paginada)
        $tools = Tool::with('user')->get();

        // 6. Pasar el listado de proyectos, el título, las herramientas y las estadísticas a la vista.
        return view('projects.index', compact('projects', 'title', 'tools', 'totalProjects', 'inProgressProjects', 'completedProjects', 'blockedProjects'));
    }


    public function create(): View
    {
        // CONTROL DE ACCESO: Llama a ProjectPolicy@create. Laravel lanza 403 si falla.
        $this->authorize('create', Project::class);

        // 1. Obtener todos los usuarios para el selector "Asignado a"
        $users = User::orderBy('name')->get(['id', 'name']);
        
        // 2. Obtener todas las herramientas para la selección múltiple
        $tools = Tool::orderBy('name')->get(['id', 'name']);
        
        // 3. Pasamos la lista de usuarios y herramientas a la vista
        return view('projects.create', compact('users', 'tools'));
    }


    public function store(Request $request): RedirectResponse
    {
        // CONTROL DE ACCESO: Llama a ProjectPolicy@create antes de guardar.
        $this->authorize('create', Project::class);
        
        // 1. Validación de datos
        $validatedData = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'status' => 'required|in:Pendiente,En proceso,Terminado,En espera de piezas',
            'priority' => 'required|in:Baja,Media,Alta,Urgente',
            'due_date' => 'nullable|date',
            'assigned_to_user_id' => 'required|exists:users,id',
            
            // Validación para la relación N:M
            'tools' => 'nullable|array',
            'tools.*' => 'exists:tools,id',
        ]);

        // 2. Creación del Proyecto
        $project = Project::create($validatedData);
        
        // 3. Manejar la relación Muchos a Muchos (Tools)
        // El sync vacío se maneja con el valor por defecto en el input: $request->input('tools', [])
        $project->tools()->sync($request->input('tools', []));

        // 4. Redirección con mensaje de éxito
        return redirect()->route('projects.index')->with('success', 'Proyecto "' . $project->name . '" creado con éxito.');
    }


    public function show(Project $project): View
    {
        // CONTROL DE ACCESO: Llama a ProjectPolicy@view($user, $project).
        $this->authorize('view', $project);

        $project->load('assignedTo', 'tools'); // Carga las relaciones necesarias
        return view('projects.show', compact('project')); // Pasa el proyecto a la vista
    }


    public function edit(Project $project): View
    {
        // CONTROL DE ACCESO: Llama a ProjectPolicy@update.
        $this->authorize('update', $project);

        // Carga todas las herramientas disponibles para el select/checkboxes
        $tools = Tool::all();

        // Obtiene los IDs de las herramientas actualmente asociadas al proyecto
        $selectedToolIds = $project->tools()->pluck('tool_id')->toArray();
        
        // Obtener todos los usuarios para el selector "Asignado a"
        $users = User::orderBy('name')->get(['id', 'name']);

        // Retorna la vista de edición, pasando el proyecto, las herramientas, usuarios y los IDs seleccionados
        return view('projects.edit', compact('project', 'tools', 'selectedToolIds', 'users'));
    }


    public function update(Request $request, Project $project): RedirectResponse
    {
        // CONTROL DE ACCESO: Llama a ProjectPolicy@update.
        $this->authorize('update', $project);
        
        // 1. Validación de los datos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Pendiente,En proceso,Terminado,En espera de piezas',
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

    public function destroy(Project $project): RedirectResponse
    {
        // CONTROL DE ACCESO: Llama a ProjectPolicy@delete.
        $this->authorize('delete', $project);
        
        // 1. Eliminamos el registro
        $projectname = $project->name; // Guardar el nombre antes de eliminar
        $project->delete();

        // 2. Redirigimos con mensaje de éxito
        return redirect()->route('projects.index')
                             ->with('success', 'El proyecto "' . $projectname . '" ha sido eliminado correctamente.');
    }
}
