<?php

namespace App\Models\Architecture;

use App\Enums\StatusAbonnement;
use App\Events\AbonnementRegistred;
use App\Events\AbonnementResilied;
use App\Traits\HasEmplacement;
use App\Traits\HasEquipement;
use App\Traits\HasSites;
use App\Traits\RecentOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\ModelStatus\HasStatuses;

/**
 * @mixin IdeHelperAbonnement
 */
class Abonnement extends Model
{
    use HasStatuses, HasSites, HasEquipement, HasEmplacement, RecentOrder;

    protected $fillable = ['code', 'equipement_id', 'emplacement_id', 'index_depart', 'index_fin', 'index_autre', 'site_id'];

    protected $table = 'abonnements';

    /**
     *
     * @var array<int, string>
     */
    protected $appends = ['status'];

    public const RULES = [
        'emplacement_id' => 'required',
        'site_id' => 'required',
    ];

    public const FINISH_RULES = [
        'index_fin' => 'required|numeric',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleted(function (Abonnement $abonnement) {
            AbonnementResilied::dispatch($abonnement);
        });

        static::saved(function (Abonnement $abonnement) {
            AbonnementRegistred::dispatch($abonnement);
        });
    }

    public function stop(): void
    {
        $this->setStatus(StatusAbonnement::STOPPED->value);
    }

    public function process(): void
    {
        $this->setStatus(StatusAbonnement::PROGRESSING->value);
    }

    public function error(): void
    {
        $this->setStatus(StatusAbonnement::ERROR->value);
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
        return $query->currentStatus(StatusAbonnement::STOPPED->value);
    }

    /**
     * Obtenir les abonnements en cours
     *
     * @param  Builder<Abonnement>  $query
     * @return Builder<Abonnement>
     */
    public function scopeProgressing(Builder $query): Builder
    {
        return $query->currentStatus(StatusAbonnement::PROGRESSING->value);
    }

    /**
     * Obtenir les abonnements en erreur d'index
     *
     * @param  Builder<Abonnement>  $query
     * @return Builder<Abonnement>
     */
    public function scopeIndexError(Builder $query): Builder
    {
        return $query->currentStatus(StatusAbonnement::ERROR->value);
    }

    /**
     * Obtenir les abonnements sans erreur d'index
     *
     * @param  Builder<Abonnement>  $query
     * @return Builder<Abonnement>
     */
    public function scopeWithoutError(Builder $query): Builder
    {
        return $query->otherCurrentStatus(StatusAbonnement::ERROR->value);
    }

    public function equipement(): BelongsTo
    {
        return $this->belongsTo(Equipement::class);
    }
}
