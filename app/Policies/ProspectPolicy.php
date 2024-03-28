<?php

namespace App\Policies;

use App\Models\Exploitation\Personne;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProspectPolicy
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
        $user->can(config('gate.exploitation.reception.prospect.global')) ? Response::allow() : Response::deny();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Exploitation\Personne  $personne
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Personne $personne)
    {
        if ($user->can(config('gate.exploitation.reception.prospect.show'))) {
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
        if ($user->can(config('gate.exploitation.reception.prospect.create'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Exploitation\Personne  $personne
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Personne $personne)
    {
        if ($user->can(config('gate.exploitation.reception.prospect.edit'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Exploitation\Personne  $personne
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Personne $personne)
    {
        if ($user->can(config('gate.exploitation.reception.prospect.trash'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Exploitation\Personne  $personne
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Personne $personne)
    {
        if ($user->can(config('gate.exploitation.reception.prospect.restore'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Exploitation\Personne  $personne
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Personne $personne)
    {
        //
    }
}
