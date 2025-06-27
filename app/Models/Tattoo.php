<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tattoo extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id',
        'body_part',
        'description',
        'image_path',
    ];

    /**
     * Define que uma tatuagem pertence a uma Pessoa.
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
