<?php

namespace App\Models;

use App\Models\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vehicle extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'plate',
        'brand',
        'model',
        'year',
        'color',
        'fuel_type',
        'renavam',
        'chassis',
        'notes',
    ];

    /**
     * Define o relacionamento muitos-para-muitos com Ocorrências.
     */
    public function occurrences(): BelongsToMany
    {
        return $this->belongsToMany(Occurrence::class, 'occurrence_vehicle');
    }
}
