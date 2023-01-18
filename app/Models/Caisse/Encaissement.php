<?php

namespace App\Models\Caisse;

use App\Events\EncaissementRegistred;
use App\Models\Exploitation\Ordonnancement;
use App\Traits\RecentOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Encaissement extends Model
{
    use RecentOrder;

    protected $fillable = ['ordonnancement_id', 'payable_id', 'caissier_id'];

    const RULES = [
        'ordonnancement_id' => 'required',
    ];

    /**
     * The "booted" method of the model.
     *
     */
    protected static function booted(): void
    {
        static::saved(function (Encaissement $encaissement) {
            $ordonnancement = Ordonnancement::with(['paiements.facture'])->findOrFail($encaissement->ordonnancement_id);
            EncaissementRegistred::dispatch($ordonnancement);
        });
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
