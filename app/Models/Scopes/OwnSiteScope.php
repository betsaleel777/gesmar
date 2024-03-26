<?php

namespace App\Models\Scopes;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class OwnSiteScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $user = User::with('sites')->find(auth()->user()->id);
        $builder->when(!$user->hasRole(SUPERROLE), fn(Builder $query): Builder =>
            $query->whereHas('site', fn(Builder $query): Builder => $query->whereIn("sites.id", $user->sites->modelkeys())));
    }
}
