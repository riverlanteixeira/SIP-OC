<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'address',
        'city',
        'state',
        'postal_code',
        'latitude',
        'longitude',
        'notes',
        'registration_date', // Campo adicionado
    ];

    protected $casts = [
        'registration_date' => 'date', // Garante que é tratado como um objeto de data
    ];
}
