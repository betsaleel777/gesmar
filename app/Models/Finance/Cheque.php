<?php

namespace App\Models\Finance;

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

    protected $fillable = ['numero', 'banque_id', 'compte_id', 'valeur'];

    const RULES = [
        'montant' => 'required',
        'banque_id' => 'required',
        'compte_id' => 'required',
        'numero' => 'required',
        'valeur' => 'required|same:montant',
    ];

    public function encaissement(): MorphOne
    {
        return $this->morphOne(Encaissement::class, 'payable');
    }

    public function banque(): BelongsTo
    {
        return $this->belongsTo(Banque::class);
    }
}
