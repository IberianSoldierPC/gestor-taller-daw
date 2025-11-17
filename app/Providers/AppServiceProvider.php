<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; // <-- Importamos la clase Gate
use App\Models\Project;              // <-- Importamos el Modelo Project
use App\Policies\ProjectPolicy;      // <-- Importamos la Policy

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Mapeamos el Modelo Project a su Policy
        Gate::policy(Project::class, ProjectPolicy::class);
    }
}
