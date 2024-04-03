<?php

namespace App\Policies;

use App\Models\Architecture\Abonnement;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AbonnementPolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    private static function userCheck(User $user, Abonnement $abonnement): bool
    {
        return $abonnement->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    public function viewAny(User $user)
    {
        $user->can(config('gate.abonnement.list-global')) ? Response::allow() : Response::deny();
    }

    public function view(User $user, Abonnement $abonnement): bool
    {
        if ($user->can(config('gate.abonnement.show'))) {
            return $user->can(config('gate.abonnement.list-own')) ? self::userCheck($user, $abonnement) : true;
        } else {
            return false;
        }
    }

    public function create(User $user): bool
    {
        return $user->can(config('gate.abonnement.create')) ? true : false;
    }

    public function update(User $user, Abonnement $abonnement): bool
    {
        if ($user->can(config('gate.abonnement.edit'))) {
            return $user->can(config('gate.abonnement.list-own')) ? self::userCheck($user, $abonnement) : true;
        } else {
            return false;
        }
    }

    public function delete(User $user, Abonnement $abonnement): bool
    {
        if ($user->can(config('gate.abonnement.trash'))) {
            return $user->can(config('gate.abonnement.list-own')) ? self::userCheck($user, $abonnement) : true;
        } else {
            return false;
        }
    }

    public function abort(User $user, Abonnement $abonnement): bool
    {
        if ($user->can(config('gate.abonnement.abort'))) {
            return $user->can(config('gate.abonnement.list-own')) ? self::userCheck($user, $abonnement) : true;
        } else {
            return false;
        }
    }

    public function restore(User $user, Abonnement $abonnement): bool
    {
        if ($user->can(config('gate.abonnement.restore'))) {
            return $user->can(config('gate.abonnement.list-own')) ? self::userCheck($user, $abonnement) : true;
        } else {
            return false;
        }
    }

    public function forceDelete(User $user, Abonnement $abonnement): bool
    {
        if ($user->can(config('gate.abonnement.delete'))) {
            return $user->can(config('gate.abonnement.list-own')) ? self::userCheck($user, $abonnement) : true;
        } else {
            return false;
        }
    }
}
