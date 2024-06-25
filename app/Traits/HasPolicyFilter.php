<?php

namespace App\Traits;

use App\Models\User;

trait HasPolicyFilter
{
    public function before(User $user): bool | null
    {
        if ($user->hasRole(config('constants.SUPERROLE'))) {
            return true;
        }
        return null;
    }
}
