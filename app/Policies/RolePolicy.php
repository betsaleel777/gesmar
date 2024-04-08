<?php

namespace App\Policies;

use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    public function viewAny(User $user): bool
    {
        return $user->can(config('gate.role.list')) ? true : false;
    }

    public function create(User $user): bool
    {
        return $user->can(config('gate.role.create')) ? true : false;
    }

    public function update(User $user): bool
    {
        return $user->can(config('gate.role.edit')) ? true : false;
    }

    public function delete(User $user): bool
    {
        return $user->can(config('gate.role.trash')) ? true : false;
    }

    public function restore(User $user): bool
    {
        return $user->can(config('gate.role.restore')) ? true : false;
    }

    public function forceDelete(User $user): bool
    {
        return $user->can(config('gate.role.delete')) ? true : false;
    }
}
