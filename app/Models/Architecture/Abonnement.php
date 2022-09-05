<?php

namespace App\Models\Architecture;

use App\Enums\StatusAbonnement;
use App\Enums\StatusEquipement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\ModelStatus\HasStatuses;

/**
 * @mixin IdeHelperAbonnement
 */
class Abonnement extends Model
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

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleted(function (Abonnement $abonnement) {
            $equipement = Equipement::findOrFail($abonnement->equipement_id);
            $equipement->desabonner();
        });

        static::saved(function (Abonnement $abonnement) {
            $equipement = Equipement::findOrFail($abonnement->equipement_id);
            $equipement->emplacement_id = $abonnement->emplacement_id;
            $equipement->save();
            $equipement->abonement === StatusEquipement::LINKED->value ?: $equipement->lier();
            $equipement->abonner();
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
