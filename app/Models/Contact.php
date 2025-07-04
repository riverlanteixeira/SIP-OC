<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id',
        'type',
        'value',
    ];

    /**
     * Define que um contacto pertence a uma Pessoa.
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
