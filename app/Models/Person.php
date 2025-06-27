<?php

namespace App\Models;

use App\Models\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;




class Person extends Model
{
    use HasFactory, Traits\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'cpf',
        'birth_date',
        'notes',
        'photo_path',
        'rg',
        'nickname',
        'father_name',
        'mother_name',
        'nationality',
        'birth_place',
        'gender',
        'skin_color',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
    ];

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function incarcerations(): HasMany
    {
        return $this->hasMany(Incarceration::class)->orderBy('entry_date', 'desc');
    }

    /**
     * Define o relacionamento com Organizações, incluindo o dado extra da tabela-pivô.
     */
    public function organizations(): BelongsToMany
    {
        // CORREÇÃO: Removido o ->withTimestamps() pois a tabela pivô não tem essas colunas.
        return $this->belongsToMany(Organization::class, 'organization_person')
                    ->withPivot('role');
    }

    /**
     * Define o relacionamento muitos-para-muitos com Investigações.
     */
    public function investigations(): BelongsToMany
    {
        return $this->belongsToMany(Investigation::class, 'investigation_person');
    }

    /**
     * Obtém todos os documentos para a pessoa.
     */
    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    /**
     * Obtém todas as tatuagens para a pessoa.
     */
    public function tattoos(): HasMany
    {
        return $this->hasMany(Tattoo::class);
    }
    public function bankAccounts(): BelongsToMany
    {
        return $this->belongsToMany(BankAccount::class, 'bank_account_person');
    }
    
}
