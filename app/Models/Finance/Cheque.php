<?php

namespace App\Models\Finance;

use App\Models\Caisse\Banque;
use App\Models\Caisse\Encaissement;
use App\Models\Scopes\RecentScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @mixin IdeHelperCheque
 */
class Cheque extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['numero', 'banque_id', 'compte_id', 'valeur'];

    const RULES = [
        'montant' => 'required',
        'banque_id' => 'required',
        'compte_id' => 'required',
        'numero' => 'required',
        'valeur' => 'required|same:montant',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new RecentScope);
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
