<?php

namespace App\Policies;

use App\Models\Template\TermesContratAnnexe;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;

class TermesContratAnnexePolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        if ($user->can(config('gate.parametre.acces.gabaris'))) {return true;}
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TermesContratAnnexe $termesContratAnnexe)
    {
        if ($user->can(config('gate.parametre.acces.gabaris'))) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        if ($user->can(config('gate.parametre.acces.gabaris'))) {return true;}
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TermesContratAnnexe $termesContratAnnexe)
    {
        if ($user->can(config('gate.parametre.acces.gabaris'))) {return true;}
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TermesContratAnnexe $termesContratAnnexe)
    {
        if ($user->can(config('gate.parametre.acces.gabaris'))) {return true;}
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TermesContratAnnexe $termesContratAnnexe)
    {
        if ($user->can(config('gate.parametre.acces.gabaris'))) {return true;}
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TermesContratAnnexe $termesContratAnnexe)
    {
        if ($user->can(config('gate.parametre.acces.gabaris'))) {return true;}
    }
}
