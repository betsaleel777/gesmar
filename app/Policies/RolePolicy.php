<?php

namespace App\Policies;

use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    public function viewAny(User $user)
    {
        if ($user->can(config('gate.parametre.acces.utilisateur'))) {
            return true;
        }
    }

    public function view(User $user, Role $role)
    {
        if ($user->can(config('gate.parametre.acces.utilisateur'))) {
            return true;
        }
    }

    public function create(User $user)
    {
        if ($user->can(config('gate.parametre.acces.utilisateur'))) {
            return true;
        }
    }

    public function update(User $user, Role $role)
    {
        if ($user->can(config('gate.parametre.acces.utilisateur'))) {
            return true;
        }
    }

    public function delete(User $user, Role $role)
    {
        if ($user->can(config('gate.parametre.acces.utilisateur'))) {
            return true;
        }
    }

    public function restore(User $user, Role $role)
    {
        if ($user->can(config('gate.parametre.acces.utilisateur'))) {
            return true;
        }
    }

    public function forceDelete(User $user, Role $role)
    {
        if ($user->can(config('gate.parametre.acces.utilisateur'))) {
            return true;
        }
    }
}
