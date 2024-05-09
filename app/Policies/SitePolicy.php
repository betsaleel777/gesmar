<?php

namespace App\Policies;

use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;

class SitePolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    public function viewAny(): bool
    {
        return true;
    }

    public function view(User $user): bool
    {
        return $user->can(config('gate.site.show')) ? true : false;
    }

    public function create(User $user): bool
    {
        return $user->can(config('gate.site.create')) ? true : false;
    }

    public function update(User $user): bool
    {
        return $user->can(config('gate.site.edit')) ? true : false;
    }

    public function delete(User $user): bool
    {
        return $user->can(config('gate.site.trash')) ? true : false;
    }

    public function restore(User $user): bool
    {
        return $user->can(config('gate.site.restore')) ? true : false;
    }
}
