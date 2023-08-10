<?php

namespace App\Policies;

use App\Models\Caisse\Banque;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BanquePolicy
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
        if ($user->can(config('gate.parametre.acces.caisse'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Caisse\Banque  $banque
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Banque $banque)
    {
        if ($user->can(config('gate.parametre.acces.caisse'))) {
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
        if ($user->can(config('gate.parametre.acces.caisse'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Caisse\Banque  $banque
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Banque $banque)
    {
        if ($user->can(config('gate.parametre.acces.caisse'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Caisse\Banque  $banque
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Banque $banque)
    {
        if ($user->can(config('gate.parametre.acces.caisse'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Caisse\Banque  $banque
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Banque $banque)
    {
        if ($user->can(config('gate.parametre.acces.caisse'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Caisse\Banque  $banque
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Banque $banque)
    {
        if ($user->can(config('gate.parametre.acces.caisse'))) {
            return true;
        }
    }
}
