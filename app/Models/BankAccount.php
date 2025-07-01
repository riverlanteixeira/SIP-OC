<?php

namespace App\Models;

use App\Models\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BankAccount extends Model
{
    use HasFactory, Traits\Auditable;

    protected $fillable = [
        'bank_name',
        'agency_number',
        'account_number',
        'account_type',
    ];

    /**
     * Define o relacionamento muitos-para-muitos com Pessoas.
     */
    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'bank_account_person');
    }
    public function occurrences(): BelongsToMany
    {
        return $this->belongsToMany(Occurrence::class, 'bank_account_occurrence');
    }
}
