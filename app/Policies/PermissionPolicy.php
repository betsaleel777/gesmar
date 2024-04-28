<?php

namespace App\Policies;

use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Response;

class PermissionPolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    public function viewAny(User $user): Response
    {
        return $user->can(config('gate.permission.list')) ? Response::allow() : Response::deny();
    }

    public function update(User $user): bool
    {
        return $user->can(config('gate.permission.edit')) ? true : false;
    }
}
