<?php

namespace App\Models\Finance;

use App\Events\CollecteRemoved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @mixin IdeHelperCollecte
 */
class Collecte extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['nombre', 'montant', 'attribution_id', 'non_paye'];
    protected $dates = ['created_at'];

    const RULES = [
        'commercial' => 'required',
        'bordereau' => 'required',
        'attribution_id' => 'required',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'nombre' => 'integer',
        'montant' => 'integer',
        'attribution_id' => 'integer',
        'non_paye' => 'boolean'
    ];

    /**
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::deleted(function (Collecte $collecte) {
            CollecteRemoved::dispatch($collecte);
        });
    }
    /**
     * Obtenir l'attribution lié a une collecte
     *
     * @return BelongsTo<Attribution, Collecte>
     */
    public function attribution(): BelongsTo
    {
        return $this->belongsTo(Attribution::class);
    }
}
