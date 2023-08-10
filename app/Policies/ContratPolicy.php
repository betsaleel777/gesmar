<?php

namespace App\Policies;

use App\Models\Exploitation\Contrat;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ContratPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        $user->can(config('gate.exploitation.reception.demande.global')) ? Response::allow() : Response::deny();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Contrat $contrat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Contrat $contrat)
    {
        if ($user->can(config('gate.exploitation.reception.demande.show'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if ($user->can(config('gate.exploitation.reception.demande.create'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Contrat $contrat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Contrat $contrat)
    {

        if ($user->can(config('gate.exploitation.reception.demande.edit'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Contrat $contrat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Contrat $contrat)
    {
        if ($user->can(config('gate.exploitation.reception.demande.trash'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Contrat $contrat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Contrat $contrat)
    {
        if ($user->can(config('gate.exploitation.reception.demande.restore'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Contrat $contrat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Contrat $contrat)
    {
        return true;
    }
}
