<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\Project;
use App\Models\Tool;
use App\Policies\ProjectPolicy;
use App\Policies\ToolPolicy;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Sin servicios adicionales a registrar en esta aplicación.
    }

    public function boot(): void
    {
        Gate::policy(Project::class, ProjectPolicy::class);
        Gate::policy(Tool::class, ToolPolicy::class);
    }
}
