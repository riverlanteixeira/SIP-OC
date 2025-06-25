<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany; // Adicionado

class Person extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser atribuídos em massa.
     */
    protected $fillable = [
        'full_name',
        'cpf',
        'birth_date',
        'notes',
        'photo_path',
    ];

    /**
     * Os atributos que devem ser convertidos para tipos nativos.
     */
    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Define o relacionamento muitos-para-muitos com Organizações.
     */
    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class, 'organization_person');
    }

    /**
     * Define o relacionamento muitos-para-muitos com Investigações.
     */
    public function investigations(): BelongsToMany
    {
        return $this->belongsToMany(Investigation::class, 'investigation_person');
    }

    /**
     * Obtém todos os documentos para a pessoa.
     */
    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
