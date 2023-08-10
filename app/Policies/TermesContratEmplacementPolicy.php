<?php

namespace App\Policies;

use App\Models\Template\TermesContratEmplacement;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TermesContratEmplacementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        if ($user->can(config('gate.parametre.acces.gabaris'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Template\TermesContratEmplacement  $termesContrat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, TermesContratEmplacement $termesContrat)
    {
        if ($user->can(config('gate.parametre.acces.gabaris'))) {
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
        if ($user->can(config('gate.parametre.acces.gabaris'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Template\TermesContratEmplacement  $termesContrat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, TermesContratEmplacement $termesContrat)
    {
        if ($user->can(config('gate.parametre.acces.gabaris'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Template\TermesContratEmplacement  $termesContrat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, TermesContratEmplacement $termesContrat)
    {
        if ($user->can(config('gate.parametre.acces.gabaris'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Template\TermesContratEmplacement  $termesContrat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, TermesContratEmplacement $termesContrat)
    {
        if ($user->can(config('gate.parametre.acces.gabaris'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Template\TermesContratEmplacement  $termesContrat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, TermesContratEmplacement $termesContrat)
    {
        if ($user->can(config('gate.parametre.acces.gabaris'))) {
            return true;
        }
    }
}
