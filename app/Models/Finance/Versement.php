<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperVersement
 */
class Versement extends Model
{
    use HasFactory;

    protected $table = 'versements';

    protected $fillable = ['montant', 'monnaie', 'espece', 'facture_id'];

    const RULES = [
        'monnaie' => 'nullable|lt:espece|numeric',
        'montant' => 'required|numeric',
        'espece' => 'nullable|numeric',
        'facture_id' => 'required',
    ];

    // scope

    /**
     * Undocumented function
     *
     * @param Builder<Versement> $query
     * @return Builder<Versement>
     */
    public function scopeIsAnnexe(Builder $query): Builder
    {
        return $query->with(['facture' => function ($query) {
            return $query->whereNotNull('annexe_id');
        }]);
    }

    /**
     * Undocumented function
     *
     * @param Builder<Versement> $query
     * @return Builder<Versement>
     */
    public function scopeIsInitiale(Builder $query)
    {
        return $query->with(['facture' => function (Builder $query): Builder {
            return $query->whereNull('annexe_id')->whereNull('periode')->whereNull('equipement_id');
        },
        ]);
    }

    /**
     * Undocumented function
     *
     * @param Builder<Versement> $query
     * @return Builder<Versement>
     */
    public function scopeIsEquipement(Builder $query): Builder
    {
        return $query->with(['facture' => function (Builder $query): Builder {
            return $query->whereNotNull('equipement_id');
        }]);
    }

    /**
     * Undocumented function
     *
     * @param Builder<Versement> $query
     * @return Builder<Versement>
     */
    public function scopeIsLoyer(Builder $query): Builder
    {
        return $query->with(['facture' => function (Builder $query): Builder {
            return $query->whereNotNull('periode');
        }]);
    }

    // relations

    /**
     * Undocumented function
     *
     * @return BelongsTo<Facture>
     */
    public function facture(): BelongsTo
    {
        return $this->belongsTo(Facture::class);
    }
}
