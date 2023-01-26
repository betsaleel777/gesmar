<?php
namespace App\Traits;

use App\Models\Exploitation\Contrat;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Obtenir lees contrats qui sont liés à un model
 */
trait HasContrats
{
    public function contrats(): HasMany
    {
        return $this->hasMany(Contrat::class);
    }
}
