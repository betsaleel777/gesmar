<?php

namespace App\Models\Finance;

use App\Enums\StatusBordereau;
use App\Enums\StatusCollecte;
use App\StateMachines\BordereauStatusMachine;
use App\Traits\HasCashStatus;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\ModelStatus\HasStatuses;

/**
 * @mixin IdeHelperBordereau
 */
class Bordereau extends Model implements Auditable
{
    use HasStatuses, HasCashStatus, HasStateMachines;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['code', 'commercial_id', 'date_attribution'];
    protected $dates = ['created_at'];
    protected $casts = ['date_attribution' => 'date'];
    protected $auditExclude = ['code'];
    protected $stateMachines = ['collected' => BordereauStatusMachine::class];
    /**
     *
     * @var array<int, string>
     */
    protected $appends = ['status'];

    const RULES = [
        'commercial_id' => 'required',
        'date_attribution' => 'required',
    ];

    public function codeGenerate(): void
    {
        $rang = $this->count() + 1;
        $this->attributes['code'] = BORDEREAU_CODE_PREFIXE . str_pad((string) $rang, 7, '0', STR_PAD_LEFT);
    }

    public function setCollected(): void
    {
        $this->collected()->transitionTo(StatusCollecte::COLLECTED->value);
    }

    public function setUnCollected(): void
    {
        $this->collected()->transitionTo(StatusCollecte::UNCOLLECTED->value);
    }

    /**
     *
     * @param  Builder<Bordereau>  $query
     * @return Builder<Bordereau>
     */
    public function scopeCashed(Builder $query): Builder
    {
        return $query->currentStatus(StatusBordereau::ENCAISSE->value);
    }

    /**
     *
     * @param  Builder<Bordereau>  $query
     * @return Builder<Bordereau>
     */
    public function scopeNotCashed(Builder $query): Builder
    {
        return $query->currentStatus(StatusBordereau::PAS_ENCAISSE->value);
    }

    public function scopeIsCollected(Builder $query): Builder
    {
        return $query->where('collected', StatusCollecte::COLLECTED->value);
    }

    public function scopeUnCollected(Builder $query): Builder
    {
        return $query->where('collected', StatusCollecte::UNCOLLECTED->value);
    }

    /**
     * Obtenir les attributions d'un bordereau
     *
     * @return HasMany<Attribution>
     */
    public function attributions(): HasMany
    {
        return $this->hasMany(Attribution::class);
    }

    /**
     * Obtenir le commercial d'un bordereau
     *
     * @return BelongsTo<Commercial, Bordereau>
     */
    public function commercial(): BelongsTo
    {
        return $this->belongsTo(Commercial::class);
    }
}
