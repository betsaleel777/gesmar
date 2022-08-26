<?php

namespace App\Models\Architecture;

use App\Enums\StatusAbonnement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\ModelStatus\HasStatuses;

/**
 * @mixin IdeHelperAbonnement
 */
class Abonnement extends Pivot
{
    use HasStatuses;

    protected $fillable = ['code', 'equipement_id', 'emplacement_id', 'index_depart', 'index_fin', 'index_autre', 'site_id'];

    protected $table = 'abonnements';

    protected $appends = ['status'];
    protected $with = ['statuses'];

    public const RULES = [
        'emplacement_id' => 'required',
        'site_id' => 'required',
    ];

    public const FINISH_RULES = [
        'index_fin' => 'required|numeric',
    ];

    public function stop(): void
    {
        $this->setStatus(StatusAbonnement::STOPPED->value);
    }

    public function process(): void
    {
        $this->setStatus(StatusAbonnement::PROGRESSING->value);
    }

    // scopes

    /**
     * Obtenir les abonnements résiliés
     *
     * @param  Builder<Abonnement>  $query
     * @return Builder<Abonnement>
     */
    public function scopeStopped(Builder $query): Builder
    {
        return $query->whereHas('statuses', function ($query) {
            return $query->where('name', StatusAbonnement::STOPPED->value, true) ;
        });
    }

    /**
     * Obtenir les abonnements en cours
     *
     * @param  Builder<Abonnement>  $query
     * @return Builder<Abonnement>
     */
    public function scopeProgressing(Builder $query): Builder
    {
        return $query->whereHas('statuses', function ($query) {
            return $query->where('name', StatusAbonnement::PROGRESSING->value, true) ;
        });
    }

    /**
     * Obtenir l'unique équipement qui est lié à cet abonnement
     *
     * @return BelongsTo<Equipement, Abonnement>
     */
    public function equipement(): BelongsTo
    {
        return $this->belongsTo(Equipement::class);
    }

    /**
     * Obtenir l'unique emplacement qui est lié à cet abonnement
     *
     * @return BelongsTo<Emplacement, Abonnement>
     */
    public function emplacement(): BelongsTo
    {
        return $this->belongsTo(Emplacement::class);
    }

    /**
     * Obtenir l'unique site (marché) qui est lié à cet abonnement
     *
     * @return BelongsTo<Site, Abonnement>
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
