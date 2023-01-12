<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @mixin IdeHelperPaiementLigne
 */
class PaiementLigne extends Model
{
    use HasFactory;

    protected $table = 'paiement_lignes';

    protected $fillable = ['fournisseur', 'code', 'montant'];

    const RULES = [
        'fournisseur' => 'required',
        'montant' => 'required',
    ];

    public function encaissement(): MorphOne
    {
        return $this->morphOne(Encaissement::class, 'payable');
    }

}
