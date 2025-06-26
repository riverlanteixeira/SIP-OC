<?php

namespace App\Models;

use App\Models\Traits\Auditable; // Importa a Trait
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Investigation extends Model
{
    use HasFactory, Auditable;
    use HasFactory;

    /**
     * Os atributos que podem ser atribuídos em massa.
     */
    protected $fillable = [
        'case_name',
        'description',
        'status',
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
    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
