<?php

namespace App\Models\Caisse;

use App\Enums\StatusEncaissement;
use App\Events\EncaissementRegistred;
use App\Models\Exploitation\Ordonnancement;
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
    protected $fillable = ['ordonnancement_id', 'payable_id', 'caissier_id'];

    const RULES = [
        'ordonnancement_id' => 'required',
    ];
    protected $appends = ['status'];
    /**
     * The "booted" method of the model.
     *
     */
    protected static function booted(): void
    {
        static::saved(function (Encaissement $encaissement) {
            $ordonnancement = Ordonnancement::with(['paiements.facture'])->findOrFail($encaissement->ordonnancement_id);
            $encaissement->setOpened();
            EncaissementRegistred::dispatch($ordonnancement);
        });
    }

    public function setClosed(): void
    {
        $this->setStatus(StatusEncaissement::CLOSED->value);
    }

    public function setOpened(): void
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
}
