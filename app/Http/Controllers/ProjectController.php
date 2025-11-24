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
    /**
     * Muestra un listado de los recursos (Proyectos).
     */
    public function index(): View
    {
        $user = Auth::user();

        // 1. Determinar la consulta base (Eager loading de relaciones y ordenar)
        $query = Project::with('assignedTo', 'tools')->orderBy('name', 'asc');

        // 2. Aplicar filtro basado en el rol del usuario
        if ($user->role === 'admin') {
            $title = 'Todos los Proyectos del Taller';
        } else {
            // El empleado solo ve los proyectos que le han sido asignados
            $query->where('assigned_to_user_id', $user->id);
            $title = 'Mis Proyectos Asignados';
        }

        // 3. CORRECCIÓN CLAVE: Aplicar paginación (ej. 10 elementos por página)
        // Esto asegura que la variable $projects sea un objeto Paginator y no una Collection,
        // lo que permite usar los métodos hasPages() y links() en la vista.
        $projects = $query->paginate(10);

        // 4. Cargar la lista de herramientas (como lista de referencia, no paginada)
        $tools = Tool::with('user')->get();

        // 5. Pasar el listado de proyectos, el título y las herramientas a la vista.
        return view('projects.index', compact('projects', 'title', 'tools'));
    }

    /**
     * Muestra el formulario para crear un nuevo recurso. (Solo Admin)
     */
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

    /**
     * Store a newly created resource in storage. (Solo Admin)
     */
    public function store(Request $request): RedirectResponse
    {
        // CONTROL DE ACCESO: Llama a ProjectPolicy@create antes de guardar.
        $this->authorize('create', Project::class);
        
        // 1. Validación de datos
        $validatedData = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'status' => 'required|in:Pendiente,En Proceso,Terminado,En Espera de Piezas',
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

    /**
     * Display the specified resource.
     */
    public function show(Project $project): View
    {
        // CONTROL DE ACCESO: Llama a ProjectPolicy@view($user, $project).
        $this->authorize('view', $project);

        $project->load('assignedTo', 'tools'); // Carga las relaciones necesarias
        return view('projects.show', compact('project')); // Pasa el proyecto a la vista
    }

    /**
     * Show the form for editing the specified resource. (Solo Admin)
     */
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

    /**
     * Update the specified resource in storage. (Solo Admin)
     */
    public function update(Request $request, Project $project): RedirectResponse
    {
        // CONTROL DE ACCESO: Llama a ProjectPolicy@update.
        $this->authorize('update', $project);
        
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
