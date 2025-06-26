<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Document extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser atribuídos em massa.
     */
    protected $fillable = [
        'original_name',
        'path',
        'documentable_id',
        'documentable_type',
    ];

    /**
     * Define o relacionamento muitos-para-muitos com Pessoas.
     */
    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'investigation_person');
    }

    /**
     * Define o relacionamento muitos-para-muitos com Organizações.
     */
    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class, 'investigation_organization');
    }

    /**
     * Define o relacionamento muitos-para-muitos com Utilizadores (Responsáveis).
     */
    public function assignedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'investigation_user');
    }

    /**
     * Obtém todos os documentos para a investigação.
     */
    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }
}
