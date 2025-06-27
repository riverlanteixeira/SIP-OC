<?php

namespace App\Policies;

use App\Models\Person;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PersonPolicy
{
    /**
     * Executa verificações de pré-autorização.
     * Se o utilizador for admin, permite qualquer ação imediatamente.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return null; // Deixa os outros métodos da policy decidirem.
    }

    /**
     * Determina se o utilizador pode ver a lista de pessoas.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determina se o utilizador pode ver uma pessoa específica.
     */
    public function view(User $user, Person $person): bool
    {
        return true;
    }

    /**
     * Determina se o utilizador pode criar pessoas.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('investigator');
    }

    /**
     * Determina se o utilizador pode atualizar os dados de uma pessoa.
     */
    public function update(User $user, Person $person): bool
    {
        // Permite se o utilizador for um investigador.
        // Numa fase posterior, poderíamos adicionar uma regra mais complexa,
        // como verificar se eles partilham uma investigação.
        return $user->hasRole('investigator');
    }

    /**
     * Determina se o utilizador pode apagar uma pessoa.
     */
    public function delete(User $user, Person $person): bool
    {
        // Apenas um admin pode apagar (verificado no método 'before').
        // Um investigador não pode.
        return false;
    }
}
