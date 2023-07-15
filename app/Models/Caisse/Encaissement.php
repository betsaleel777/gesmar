<?php

namespace App\Models\Caisse;

use App\Enums\StatusEncaissement;
use App\Events\EncaissementRegistred;
use App\Models\Exploitation\Ordonnancement;
use App\Models\Scopes\RecentScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\ModelStatus\HasStatuses;

/**
 * @mixin IdeHelperEncaissement
 */
class Encaissement extends Model
{
    use HasStatuses;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;
    protected $fillable = ['ordonnancement_id', 'payable_id', 'caissier_id', 'ouverture_id'];
    protected $dates = ['created_at'];
    const RULES = [
        'ordonnancement_id' => 'required',
    ];
    protected $appends = ['status'];
    protected static function booted(): void
    {
        static::addGlobalScope(new RecentScope);

        static::created(function (Encaissement $encaissement) {
            $ordonnancement = Ordonnancement::with(['paiements.facture'])->findOrFail($encaissement->ordonnancement_id);
            $encaissement->setOpen();
            EncaissementRegistred::dispatch($ordonnancement);
        });
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
