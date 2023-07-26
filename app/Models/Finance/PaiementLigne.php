<?php

namespace App\Models\Finance;

use App\Models\Caisse\Encaissement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @mixin IdeHelperPaiementLigne
 */
class PaiementLigne extends Model
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'paiement_lignes';

    protected $fillable = ['fournisseur', 'code', 'montant'];
    protected $auditExclude = ['code'];

    const RULES = [
        'fournisseur' => 'required',
        'montant' => 'required',
    ];

    /**
     * Undocumented function
     *
     * @return MorphOne<Encaissement>
     */
    public function encaissement(): MorphOne
    {
        return $this->morphOne(Encaissement::class, 'payable');
    }
}
