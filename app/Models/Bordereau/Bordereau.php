<?php

namespace App\Models\Bordereau;

use App\Enums\StatusBordereau;
use App\Models\Architecture\Emplacement;
use App\StateMachines\BordereauStateMachine;
use App\Traits\HasSites;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Bordereau extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, HasSites, HasStateMachines;

    protected $fillable = ['code', 'commercial_id', 'site_id', 'jour'];
    protected $dates = ['created_at'];
    protected $casts = ['jour' => 'date'];
    protected $table = 'bordereaux';
    public $stateMachines = ['status' => BordereauStateMachine::class];

    public function codeGenerate(): void
    {
        $rang = $this->count() + 1;
        $this->attributes['code'] = BORDEREAU_CODE_PREFIXE . str((string) $rang)->padLeft(5, '0') . Carbon::now()->format('y');
    }

    public function setCashed(): void
    {
        $this->status()->transitionTo(StatusBordereau::CASHED->value);
    }

    public function setUncashed(): void
    {
        $this->status()->transitionTo(StatusBordereau::UNCASHED->value);
    }

    public function scopeCashed(Builder $query): Builder
    {
        return $query->where('status', StatusBordereau::CASHED->value);
    }

    public function scopeUncashed(Builder $query): Builder
    {
        return $query->where('status', StatusBordereau::UNCASHED->value);
    }

    public function commercial(): BelongsTo
    {
        return $this->belongsTo(Commercial::class);
    }

    public function emplacements(): BelongsToMany
    {
        return $this->belongsToMany(Emplacement::class, 'bordereau_emplacement', 'bordereau_id', 'emplacement_id');
    }

    public function collectes(): HasMany
    {
        return $this->hasMany(Collecte::class, 'bordereau_id');
    }
}
