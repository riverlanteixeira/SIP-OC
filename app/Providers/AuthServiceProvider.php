<?php

namespace App\Providers;

use App\Models\User; // Adicionado
use Illuminate\Support\Facades\Gate; // Adicionado
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Define um "gate" chamado 'is-admin'
        // Ele retorna true se o utilizador tiver o papel com o slug 'admin'
        Gate::define('is-admin', function (User $user) {
            return $user->hasRole('admin');
        });
    }
}