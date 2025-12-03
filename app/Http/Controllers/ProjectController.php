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
    public function index(Request $request): View
    {
        $user = Auth::user();
        $query = Project::with('assignedTo', 'tools');
        // Filtros: nombre y estado
        if ($search = trim((string) $request->query('q'))) {
            $query->where('name', 'like', '%'.$search.'%');
        }
        if ($status = trim((string) $request->query('status'))) {
            $query->where('status', $status);
        }
        // Filtro por responsable (solo admin)
        if ($user->role === 'admin' && ($userId = $request->query('user_id'))) {
            $query->where('assigned_to_user_id', $userId);
        }
        $query->orderBy('name', 'asc');
        if ($user->role === 'admin') {
            $title = 'Todos los Proyectos del Taller';
        } else {
            $query->where('assigned_to_user_id', $user->id);
            $title = 'Mis Proyectos Asignados';
        }
        $projects = $query->paginate(10)->withQueryString();
        $baseQuery = Project::with('assignedTo', 'tools');
        if ($user->role !== 'admin') {
            $baseQuery->where('assigned_to_user_id', $user->id);
        }

        $totalProjects = $baseQuery->count();
        $inProgressProjects = (clone $baseQuery)->where('status', 'En proceso')->count();
        $completedProjects = (clone $baseQuery)->where('status', 'Terminado')->count();
        $blockedProjects = (clone $baseQuery)->where('status', 'Bloqueado')->orWhere('status', 'En espera de piezas')->count();
        $tools = Tool::with('user')->get();
        $statuses = ['Pendiente','En proceso','Terminado','En espera de piezas'];
        $users = ($user->role === 'admin') ? User::orderBy('name')->get(['id','name']) : collect();
        return view('projects.index', compact('projects', 'title', 'tools', 'totalProjects', 'inProgressProjects', 'completedProjects', 'blockedProjects', 'statuses','users'));
    }

    public function create(): View
    {
        $this->authorize('create', Project::class);
        $users = User::orderBy('name')->get(['id', 'name']);
        $tools = Tool::orderBy('name')->get(['id', 'name']);
        return view('projects.create', compact('users', 'tools'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Project::class);
        $validatedData = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'status' => 'required|in:Pendiente,En proceso,Terminado,En espera de piezas',
            'priority' => 'required|in:Baja,Media,Alta,Urgente',
            'due_date' => 'nullable|date',
            'assigned_to_user_id' => 'required|exists:users,id',
            'tools' => 'nullable|array',
            'tools.*' => 'exists:tools,id',
        ]);
        $project = Project::create($validatedData);
        $project->tools()->sync($request->input('tools', []));
        return redirect()->route('projects.index')->with('success', 'Proyecto "' . $project->name . '" creado con éxito.');
    }

    public function show(Project $project): View
    {
        $this->authorize('view', $project);
        $project->load('assignedTo', 'tools');
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project): View
    {
        $this->authorize('update', $project);
        $tools = Tool::all();
        $selectedToolIds = $project->tools()->pluck('tool_id')->toArray();
        $users = User::orderBy('name')->get(['id', 'name']);
        return view('projects.edit', compact('project', 'tools', 'selectedToolIds', 'users'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $this->authorize('update', $project);
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
        $project->update($validatedData);
        $project->tools()->sync($request->input('tools', []));
        return redirect()->route('projects.index')
                             ->with('success', '¡Proyecto actualizado exitosamente!');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->authorize('delete', $project);
        $projectname = $project->name;
        $project->delete();
        return redirect()->route('projects.index')
                             ->with('success', 'El proyecto "' . $projectname . '" ha sido eliminado correctamente.');
    }
}
