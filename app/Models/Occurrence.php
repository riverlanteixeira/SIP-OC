<?php

namespace App\Models;

use App\Models\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Occurrence extends Model
{
    use HasFactory, Traits\Auditable;

    protected $fillable = [
        'bo_number',
        'fact_date',
        'location_id',
        'report',
    ];

    protected $casts = [
        'fact_date' => 'datetime',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'occurrence_person')
                    ->withPivot('participation_type', 'individual_report')
                    ->withTimestamps();
    }

    public function crimeTypes(): BelongsToMany
    {
        return $this->belongsToMany(CrimeType::class, 'crime_type_occurrence');
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    /**
     * Define o relacionamento muitos-para-muitos com Veículos.
     */
    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(Vehicle::class, 'occurrence_vehicle');
    }

    public function bankAccounts(): BelongsToMany
    {
        return $this->belongsToMany(BankAccount::class, 'bank_account_occurrence');
    }

    public function cryptoWallets(): BelongsToMany
    {
        return $this->belongsToMany(CryptoWallet::class, 'crypto_wallet_occurrence');
    }
}
