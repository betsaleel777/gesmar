<?php

namespace App\Policies;

use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;

class SocietePolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    public function viewAny(User $user): bool
    {
        return $user->can(config('gate.application.list')) ? true : false;
    }

    public function update(User $user): bool
    {
        return $user->can(config('gate.application.edit')) ? true : false;
    }
}
