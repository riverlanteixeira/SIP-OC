<?php

namespace App\Models;

use App\Models\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CryptoWallet extends Model
{
    use HasFactory, Traits\Auditable;

    protected $fillable = [
        'coin_type',
        'address',
        'notes',
    ];
    public function occurrences(): BelongsToMany
    {
        return $this->belongsToMany(Occurrence::class, 'crypto_wallet_occurrence');
    }
}
