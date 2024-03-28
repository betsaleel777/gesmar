<?php

namespace App\Policies;

use App\Models\Architecture\Emplacement;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class EmplacementPolicy
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
     * @param  \App\Models\Emplacement  $emplacement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Emplacement $emplacement)
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
     * @param  \App\Models\Emplacement  $emplacement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Emplacement $emplacement)
    {
        if ($user->can(config('gate.parametre.acces.configuration'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Emplacement  $emplacement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Emplacement $emplacement)
    {
        if ($user->can(config('gate.parametre.acces.configuration'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Emplacement  $emplacement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Emplacement $emplacement)
    {
        if ($user->can(config('gate.parametre.acces.configuration'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Emplacement  $emplacement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Emplacement $emplacement)
    {
        //
    }
}
