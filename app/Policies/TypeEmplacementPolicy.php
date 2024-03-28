<?php

namespace App\Policies;

use App\Models\Architecture\TypeEmplacement;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TypeEmplacementPolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        $user->hasRole(SUPERROLE) ? Response::allow() : Response::deny();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Architecture\TypeEmplacement  $typeEmplacement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, TypeEmplacement $typeEmplacement)
    {
        if ($user->can(config('gate.parametre.acces.configuration'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if ($user->can(config('gate.parametre.acces.configuration'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Architecture\TypeEmplacement  $typeEmplacement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, TypeEmplacement $typeEmplacement)
    {
        if ($user->can(config('gate.parametre.acces.configuration'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Architecture\TypeEmplacement  $typeEmplacement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, TypeEmplacement $typeEmplacement)
    {
        if ($user->can(config('gate.parametre.acces.configuration'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Architecture\TypeEmplacement  $typeEmplacement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, TypeEmplacement $typeEmplacement)
    {
        if ($user->can(config('gate.parametre.acces.configuration'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Architecture\TypeEmplacement  $typeEmplacement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, TypeEmplacement $typeEmplacement)
    {
        if ($user->can(config('gate.parametre.acces.configuration'))) {
            return true;
        }
    }
}
