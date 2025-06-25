<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Investigation extends Model
{
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
}