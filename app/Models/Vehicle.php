<?php

namespace App\Models;

use App\Models\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
