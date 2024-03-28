<?php

namespace App\Traits;

use App\Models\User;

trait HasPolicyFilter
{
    public function before(User $user): bool | null
    {
        if ($user->hasRole(SUPERROLE)) {return true;}
        return null;
    }
}
