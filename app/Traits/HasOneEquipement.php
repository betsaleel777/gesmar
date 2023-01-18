<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Obtenir l'unique équipement qui est lié à un model
 */
trait HasOneEquipment
{
    public function equipement(): BelongsTo
    {
        return $this->belongsTo(Equipement::class);
    }
}
