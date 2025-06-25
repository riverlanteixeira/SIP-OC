<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Este método é usado para registar serviços no container.
        // Normalmente, não se interage com a base de dados ou views aqui.
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Este método é executado depois de todos os outros provedores de serviço
        // terem sido registados. É aqui que você pode interagir com
        // o resto do framework (ex: definir gates, compor views, etc.).
        // No entanto, para permissões, o local correto é o AuthServiceProvider.
    }
}
