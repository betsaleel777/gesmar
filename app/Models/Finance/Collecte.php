<?php

namespace App\Models\Finance;

use App\Enums\StatusBordereau;
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
            $attribution = Attribution::with('bordereau')->findOrFail($collecte->attribution_id);
            if ($collecte->nombre === 1) {
                $attribution->encaisser();
            }
            // vérifier si toutes les attributions du bordereau sont encaissées en vue de changer le statut du bordereau
            $bordereau = Bordereau::with('attributions')->findOrFail($attribution->bordereau?->id);
            $bordereau->attributions->contains('status', StatusBordereau::PAS_ENCAISSE->value) ?: $bordereau->encaisser();
        });

        static::deleted(function (Collecte $collecte) {
            $attribution = Attribution::with('bordereau')->findOrFail($collecte->attribution_id);
            $attribution->pasEncaisser();
            // vérifier si toutes les attributions du bordereau sont encaissées en vue de changer le statut du bordereau
            $bordereau = Bordereau::with('attributions')->findOrFail($attribution->bordereau?->id);
            $bordereau->attributions->contains('status', StatusBordereau::PAS_ENCAISSE->value) ?: $bordereau->encaisser();
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
