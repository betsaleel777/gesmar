<?php

namespace App\Models\Architecture;

use App\Enums\StatusAbonnement;
use App\Models\Scopes\OwnSiteScope;
use App\Models\Scopes\RecentScope;
use App\Traits\HasEmplacement;
use App\Traits\HasEquipement;
use App\Traits\HasSites;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\ModelStatus\HasStatuses;

/**
 * @mixin IdeHelperAbonnement
 */
class Abonnement extends Model implements Auditable
{
    use HasStatuses, HasSites, HasEquipement, HasEmplacement;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['code', 'equipement_id', 'emplacement_id', 'index_depart', 'index_fin', 'index_autre', 'site_id'];
    protected $table = 'abonnements';
    protected $casts = ['index_depart' => 'integer', 'index_fin' => 'integer', 'index_autre' => 'integer'];
    protected $dates = ['created_at'];
    protected $auditExclude = ['code', 'site_id'];
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
     */
    protected static function booted()
    {
        static::addGlobalScope(new RecentScope);
        static::addGlobalScope(new OwnSiteScope);
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
     */
    public function scopeStopped(Builder $query): Builder
    {
        return $query->currentStatus(StatusAbonnement::STOPPED->value);
    }

    /**
     * Obtenir les abonnements en cours
     */
    public function scopeProgressing(Builder $query): Builder
    {
        return $query->currentStatus(StatusAbonnement::PROGRESSING->value);
    }

    /**
     * Obtenir les abonnements en erreur d'index
     */
    public function scopeIndexError(Builder $query): Builder
    {
        return $query->currentStatus(StatusAbonnement::ERROR->value);
    }

    /**
     * Obtenir les abonnements sans erreur d'index
     */
    public function scopeWithoutError(Builder $query): Builder
    {
        return $query->otherCurrentStatus(StatusAbonnement::ERROR->value);
    }

    /**
     * Obtenir les pavillons appartenant à la liste de site accéssible à l'utilisateur courant
     */
    public function scopeInside(Builder $query, array $sites): Builder
    {
        return $query->whereIn('site_id', $sites);
    }

    public function equipement(): BelongsTo
    {
        return $this->belongsTo(Equipement::class);
    }
}
