<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Organization extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser atribuídos em massa.
     */
    protected $fillable = [
        'name',
        'area_of_operation',
        'description',
    ];

    /**
     * Define o relacionamento muitos-para-muitos com Pessoas.
     */
    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'organization_person');
    }

    /**
     * Define o relacionamento muitos-para-muitos com Investigações.
     */
    public function investigations(): BelongsToMany
    {
        return $this->belongsToMany(Investigation::class, 'investigation_organization');
    }
}