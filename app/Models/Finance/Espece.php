<?php

namespace App\Models\Finance;

use App\Models\Caisse\Encaissement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @mixin IdeHelperEspece
 */
class Espece extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['montant', 'versement'];

    const RULES = [
        'montant' => 'required',
        'versement' => 'required',
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
