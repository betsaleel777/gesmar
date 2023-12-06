<?php

namespace App\Models\Caisse;

use App\Enums\StatusEncaissement;
use App\Models\Bordereau\Bordereau;
use App\Models\Exploitation\Ordonnancement;
use App\Models\Scopes\RecentScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\ModelStatus\HasStatuses;

/**
 * @mixin IdeHelperEncaissement
 */
class Encaissement extends Model implements Auditable
{
    use HasStatuses;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['ordonnancement_id', 'bordereau_id', 'payable_id', 'caissier_id', 'ouverture_id'];
    protected $dates = ['created_at'];
    protected $appends = ['status'];
    const RULES = ['ordonnancement_id' => 'required_without:bordereau_id', 'bordereau_id' => 'required_without:ordonnancement_id'];

    protected static function booted(): void
    {
        static::addGlobalScope(new RecentScope);
    }

    public function setClose(): void
    {
        $this->setStatus(StatusEncaissement::CLOSED->value);
    }

    public function setOpen(): void
    {
        $this->setStatus(StatusEncaissement::OPENED->value);
    }

    public function scopeClosed(Builder $query): Builder
    {
        return $query->currentStatus(StatusEncaissement::CLOSED->value);
    }

    public function scopeOpened(Builder $query): Builder
    {
        return $query->currentStatus(StatusEncaissement::OPENED->value);
    }

    // relations directes
    public function ordonnancement(): BelongsTo
    {
        return $this->belongsTo(Ordonnancement::class);
    }

    public function bordereau(): BelongsTo
    {
        return $this->belongsTo(Bordereau::class);
    }

    public function payable()
    {
        return $this->morphTo();
    }

    public function caissier(): BelongsTo
    {
        return $this->belongsTo(Caissier::class);
    }

    public function ouverture(): BelongsTo
    {
        return $this->belongsTo(Ouverture::class);
    }
}
