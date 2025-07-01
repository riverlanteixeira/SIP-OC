<?php

namespace App\Policies;

use App\Models\Person;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log; // 1. Importa a classe de Log

class PersonPolicy
{
    /**
     * Executa verificações de pré-autorização.
     */
    public function before(User $user, string $ability): bool|null
    {
        // 2. Escreve no log para sabermos que este método foi chamado
        Log::info("PersonPolicy@before: Verificando permissão '{$ability}' para o utilizador ID {$user->id}.");

        if ($user->hasRole('admin')) {
            // 3. Escreve no log se o utilizador é admin
            Log::info("PersonPolicy@before: Utilizador é ADMIN. Permissão concedida.");
            return true;
        }

        Log::info("PersonPolicy@before: Utilizador não é admin. A continuar para a verificação específica.");
        return null;
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
        // 4. Escreve no log para sabermos que este método foi chamado
        Log::info("PersonPolicy@update: Verificando permissão para o utilizador ID {$user->id}.");
        
        $isAllowed = $user->hasRole('admin') || $user->hasRole('investigator');
        
        // 5. Escreve o resultado da verificação no log
        Log::info("PersonPolicy@update: Permissão para atualizar é " . ($isAllowed ? 'true' : 'false'));

        return $isAllowed;
    }

    /**
     * Determina se o utilizador pode apagar uma pessoa.
     */
    public function delete(User $user, Person $person): bool
    {
        return false;
    }
}
