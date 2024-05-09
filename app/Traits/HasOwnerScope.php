<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasOwnerScope
{
    /**
     * Obtenir les models crée par l'utilisateur courant
     */
    public function scopeOwner(Builder $query): Builder
    {
        return $query->whereHas('audit', fn($query) => $query->where('user_id', auth()->user()->id));
    }
}
