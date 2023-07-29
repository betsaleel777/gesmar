<?php

namespace App\Policies;

use App\Models\Exploitation\Personne;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PersonnePolicy
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
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Personne  $personne
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Personne $personne)
    {
        if ($personne->checkProspect() and $user->can(config('gate.exploitation.reception.prospect.own'))) {
            return $user->id == $personne->load('audits')->audits->first()->user_id;
        }
        if ($personne->checkClient() and $user->can(config('gate.exploitation.reception.client.own'))) {
            return $user->id == $personne->load('audits')->audits->first()->user_id;
        }
        if ($personne->checkProspect() and $user->can(config('gate.exploitation.reception.prospect.global'))) {
            return true;
        }
        if ($personne->checkClient() and $user->can(config('gate.exploitation.reception.client.global'))) {
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
     * @param  \App\Models\Personne  $personne
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Personne $personne)
    {
        if ($personne->checkProspect() and $user->can(config('gate.exploitation.reception.prospect.edit'))) {
            return true;
        }
        if ($personne->checkClient() and $user->can(config('gate.exploitation.reception.client.edit'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Personne  $personne
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Personne $personne)
    {
        if ($personne->checkProspect() and $user->can(config('gate.exploitation.reception.prospect.trash'))) {
            return true;
        }
        if ($personne->checkClient() and $user->can(config('gate.exploitation.reception.client.trash'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Personne  $personne
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Personne $personne)
    {
        if ($personne->checkProspect() and $user->can(config('gate.exploitation.reception.prospect.restore'))) {
            return true;
        }
        if ($personne->checkClient() and $user->can(config('gate.exploitation.reception.client.restore'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Personne $personne
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Personne $personne)
    {
        //
    }
}
