<?php

namespace App\Policies;

use App\Models\Caisse\Compte;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ComptePolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    private static function userCheck(User $user, Compte $compte): bool
    {
        return $compte->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    public function viewAny(User $user)
    {
        $user->can(config('gate.compte.list-global')) ? Response::allow() : Response::deny();
    }

    public function view(User $user, Compte $compte)
    {
        if ($user->can(config('gate.compte.show'))) {
            return $user->can(config('gate.compte.list-own')) ? self::userCheck($user, $compte) : true;
        } else {
            return false;
        }
    }

    public function create(User $user)
    {
        return $user->can(config('gate.compte.create')) ? true : false;
    }

    public function update(User $user, Compte $compte)
    {
        if ($user->can(config('gate.compte.edit'))) {
            return $user->can(config('gate.compte.list-own')) ? self::userCheck($user, $compte) : true;
        } else {
            return false;
        }
    }
}
