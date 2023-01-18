<?php

namespace App\Models\Finance;

use App\Events\CollecteRegistred;
use App\Events\CollecteRemoved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperCollecte
 */
class Collecte extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'montant', 'attribution_id'];

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
    ];

    /**
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::saved(function (Collecte $collecte) {
            CollecteRegistred::dispatch($collecte);
        });

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
