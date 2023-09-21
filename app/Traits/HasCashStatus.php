<?php

namespace App\Traits;

use App\Enums\StatusCollecte;
use Illuminate\Database\Eloquent\Builder;

/**
 * pour les models qui ont les status d'encaissements
 */
trait HasCashStatus
{
    public function encaisser(): void
    {
        $this->setStatus(StatusCollecte::COLLECTED->value);
    }

    public function pasEncaisser(): void
    {
        $this->setStatus(StatusCollecte::UNCOLLECTED->value);
    }

    public function scopeCashed(Builder $query): Builder
    {
        return $query->currentStatus(StatusCollecte::COLLECTED->value);
    }

    public function scopeUncashed(Builder $query): Builder
    {
        return $query->currentStatus(StatusCollecte::UNCOLLECTED->value);
    }
}
