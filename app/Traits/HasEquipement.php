<?php

namespace App\Traits;

use App\Models\Architecture\Equipement;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Obtenir l'unique équipement qui est lié à un model
 */
trait HasEquipement
{
    public function equipement(): BelongsTo
    {
        return $this->belongsTo(Equipement::class);
    }
}
