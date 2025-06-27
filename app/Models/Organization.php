<?php

namespace App\Models;

use App\Models\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Organization extends Model
{
    use HasFactory, Auditable;

    /**
     * Os atributos que podem ser atribuídos em massa.
     */
    protected $fillable = [
        'name',
        'area_of_operation',
        'description',
    ];

    /**
     * Define o relacionamento com Pessoas, incluindo o dado extra da tabela-pivô.
     */
    public function people(): BelongsToMany
    {
        // CORREÇÃO: Removido o ->withTimestamps() para consistência.
        return $this->belongsToMany(Person::class, 'organization_person')
                   ->withPivot('role');
    }
    
    /**
     * Define o relacionamento muitos-para-muitos com Investigações.
     */
    public function investigations(): BelongsToMany
    {
        return $this->belongsToMany(Investigation::class, 'investigation_organization');
    }

    /**
     * Obtém todos os documentos para a organização.
     */
    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
