<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Person extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'full_name',
        'cpf',
        'birth_date',
        'notes',
        'photo_path',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Define o relacionamento muitos-para-muitos com Organizações.
     * Uma pessoa pode pertencer a várias organizações.
     */
    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class, 'organization_person');
    }

    public function investigations(): BelongsToMany
    {
        return $this->belongsToMany(Investigation::class, 'investigation_person');
    }
}