<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'auditable_id',
        'auditable_type',
        'old_values',
        'new_values',
    ];

    /**
     * Os atributos que devem ser convertidos.
     */
    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    /**
     * Relação com o utilizador que realizou a ação.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relação polimórfica para o registo que foi auditado.
     */
    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }
}
