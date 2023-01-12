<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @mixin IdeHelperCheque
 */
class Cheque extends Model
{
    use HasFactory;

    protected $fillable = ['numero', 'banque_id', 'encaisse', 'montant'];

    const RULES = [
        'numero' => 'required',
        'banque' => 'required',
        'montant' => 'required',
    ];

    public function valider(): void
    {
        $this->attributes['encaisser'] = true;
    }

    /**
     * Undocumented function
     *
     * @param  Builder<Cheque>  $query
     * @return Builder<Cheque>
     */
    public function isValid(Builder $query): Builder
    {
        return $query->where('encaisse', true);
    }

    public function encaissement(): MorphOne
    {
        return $this->morphOne(Encaissement::class, 'payable');
    }

    public function banque(): BelongsTo
    {
        return $this->belongsTo(Banque::class);
    }
}
