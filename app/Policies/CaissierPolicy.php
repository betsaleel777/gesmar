<?php

namespace App\Policies;

use App\Models\Caisse\Caissier;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CaissierPolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    private static function userCheck(User $user, Caissier $caissier): bool
    {
        return $caissier->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    public function viewAny(User $user)
    {
        $user->can(config('gate.caissier.list-global')) ? Response::allow() : Response::deny();
    }

    public function view(User $user, Caissier $caissier): bool
    {
        return $user->can(config('gate.caissier.list-own')) ? self::userCheck($user, $caissier) : true;
    }

    public function create(User $user): bool
    {
        return $user->can(config('gate.caissier.create')) ? true : false;
    }

    public function delete(User $user, Caissier $caissier): bool
    {
        if ($user->can(config('gate.caissier.trash'))) {
            return $user->can(config('gate.caissier.list-own')) ? self::userCheck($user, $caissier) : true;
        } else {
            return false;
        }
    }

    public function restore(User $user, Caissier $caissier): bool
    {
        if ($user->can(config('gate.caissier.restore'))) {
            return $user->can(config('gate.caissier.list-own')) ? self::userCheck($user, $caissier) : true;
        } else {
            return false;
        }
    }

    public function attribuate(User $user, Caissier $caissier): bool
    {
        if ($user->can(config('gate.caissier.attribuate'))) {
            return $user->can(config('gate.caissier.list-own')) ? self::userCheck($user, $caissier) : true;
        } else {
            return false;
        }
    }
}
