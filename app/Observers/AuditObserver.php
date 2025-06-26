<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditObserver
{
    /**
     * Lida com o evento "created" (criado).
     */
    public function created(Model $model): void
    {
        $this->logAction('created', $model);
    }

    /**
     * Lida com o evento "updated" (atualizado).
     */
    public function updated(Model $model): void
    {
        $this->logAction('updated', $model);
    }

    /**
     * Lida com o evento "deleted" (apagado).
     */
    public function deleted(Model $model): void
    {
        $this->logAction('deleted', $model);
    }

    /**
     * Função auxiliar para criar o registo de log.
     */
    protected function logAction(string $action, Model $model): void
    {
        AuditLog::create([
            'user_id' => Auth::id(), // ID do utilizador logado
            'action' => $action,
            'auditable_id' => $model->id,
            'auditable_type' => get_class($model),
            // getOriginal() pega os dados ANTES da alteração
            'old_values' => $action === 'updated' ? $model->getOriginal() : null,
            // getAttributes() pega os dados DEPOIS da alteração
            'new_values' => $action !== 'deleted' ? $model->getAttributes() : null,
        ]);
    }
}
