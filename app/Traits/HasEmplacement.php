<?php
namespace App\Traits;

use App\Models\Architecture\Emplacement;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Obtenir l'unique emplacement qui est lié à un model
 */
trait HasEmplacement
{
    public function emplacement(): BelongsTo
    {
        return $this->belongsTo(Emplacement::class);
    }
}
