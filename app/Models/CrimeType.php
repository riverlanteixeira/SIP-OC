<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CrimeType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function occurrences(): BelongsToMany
    {
        return $this->belongsToMany(Occurrence::class, 'crime_type_occurrence');
    }
}
