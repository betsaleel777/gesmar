<?php

namespace App\Traits;

use App\Enums\StatusBordereau;
use Illuminate\Database\Eloquent\Builder;

/**
 * pour les models qui ont les status d'encaissements
 */
trait HasCashStatus
{
    public function encaisser(): void
    {
        $this->setStatus(StatusBordereau::ENCAISSE->value);
    }

    public function pasEncaisser(): void
    {
        $this->setStatus(StatusBordereau::PAS_ENCAISSE->value);
    }

    public function scopeCashed(Builder $query): Builder
    {
        return $query->currentStatus(StatusBordereau::ENCAISSE->value);
    }

    public function scopeUncashed(Builder $query): Builder
    {
        return $query->currentStatus(StatusBordereau::PAS_ENCAISSE->value);
    }
}
