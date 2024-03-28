<?php

namespace App\Policies;

use App\Models\Architecture\ServiceAnnexe;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ServiceAnnexePolicy
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
     * @param  \App\Models\Architecture\ServiceAnnexe  $serviceAnnexe
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ServiceAnnexe $serviceAnnexe)
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
     * @param  \App\Models\Architecture\ServiceAnnexe  $serviceAnnexe
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ServiceAnnexe $serviceAnnexe)
    {
        if ($user->can(config('gate.parametre.acces.configuration'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Architecture\ServiceAnnexe  $serviceAnnexe
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ServiceAnnexe $serviceAnnexe)
    {
        if ($user->can(config('gate.parametre.acces.configuration'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Architecture\ServiceAnnexe  $serviceAnnexe
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ServiceAnnexe $serviceAnnexe)
    {
        if ($user->can(config('gate.parametre.acces.configuration'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Architecture\ServiceAnnexe  $serviceAnnexe
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ServiceAnnexe $serviceAnnexe)
    {
        if ($user->can(config('gate.parametre.acces.configuration'))) {
            return true;
        }
    }
}
