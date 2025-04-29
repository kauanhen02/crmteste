<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('permissoes_tela', function(User $user, $habilidade) {
            $user->loadMissing([
                'perfil',
                'perfil.habilidades',
            ]);
            return $user->perfil->habilidades->contains('nome_unico', $habilidade);
        });
    }
}
