<?php

namespace App\Policies;

use App\Models\Investigation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InvestigationPolicy
{
    /**
     * Permite que administradores executem qualquer ação.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return null;
    }

    /**
     * Determina se o utilizador pode ver a lista de investigações.
     * (Neste caso, todos podem ver a página de lista, mas o controller irá filtrar os resultados)
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determina se o utilizador pode ver uma investigação específica.
     */
    public function view(User $user, Investigation $investigation): bool
    {
        // Permite se o utilizador for um dos responsáveis pelo caso.
        return $investigation->assignedUsers()->where('user_id', $user->id)->exists();
    }

    /**
     * Determina se o utilizador pode criar investigações.
     */
    public function create(User $user): bool
    {
        // Todos os utilizadores logados podem criar investigações.
        return true;
    }

    /**
     * Determina se o utilizador pode atualizar uma investigação.
     */
    public function update(User $user, Investigation $investigation): bool
    {
        return $investigation->assignedUsers()->where('user_id', $user->id)->exists();
    }

    /**
     * Determina se o utilizador pode apagar uma investigação.
     */
    public function delete(User $user, Investigation $investigation): bool
    {
        return $investigation->assignedUsers()->where('user_id', $user->id)->exists();
    }
}
