<?php
namespace App\Traits;

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
