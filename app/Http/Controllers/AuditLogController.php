<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AuditLogController extends Controller
{
    /**
     * Exibe a lista de registos de auditoria.
     */
    public function index()
    {
        // Apenas administradores podem ver a trilha de auditoria.
        if (! Gate::allows('is-admin')) {
            abort(403, 'Acesso Não Autorizado');
        }

        // Busca os logs, ordenados pelos mais recentes, e com os seus relacionamentos.
        // O método with() previne o problema N+1, carregando os dados relacionados de forma eficiente.
        $logs = AuditLog::with('user', 'auditable')
                        ->latest()
                        ->paginate(20);

        return view('audit_logs.index', compact('logs'));
    }
}
