<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Investigation;
use App\Models\Person; // Adicionado
use App\Policies\InvestigationPolicy;
use App\Policies\PersonPolicy; // Adicionado
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Investigation::class => InvestigationPolicy::class,
        Person::class => PersonPolicy::class, // Linha adicionada para registar a nova policy
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('is-admin', function (User $user) {
            return $user->hasRole('admin');
        });
    }
}
