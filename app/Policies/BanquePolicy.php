<?php

namespace App\Policies;

use App\Models\Caisse\Banque;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BanquePolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    private static function userCheck(User $user, Banque $banque): bool
    {
        return $banque->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    public function viewAny(User $user)
    {
        $user->can(config('gate.banque.list-global')) ? Response::allow() : Response::deny();
    }

    public function create(User $user): bool
    {
        return $user->can(config('gate.banque.create')) ? true : false;
    }

    public function update(User $user, Banque $banque): bool
    {
        if ($user->can(config('gate.banque.edit'))) {
            return $user->can(config('gate.banque.list-own')) ? self::userCheck($user, $banque) : true;
        } else {
            return false;
        }
    }

    public function delete(User $user, Banque $banque): bool
    {
        if ($user->can(config('gate.banque.trash'))) {
            return $user->can(config('gate.banque.list-own')) ? self::userCheck($user, $banque) : true;
        } else {
            return false;
        }
    }

    public function restore(User $user, Banque $banque): bool
    {
        if ($user->can(config('gate.banque.restore'))) {
            return $user->can(config('gate.banque.list-own')) ? self::userCheck($user, $banque) : true;
        } else {
            return false;
        }
    }

    public function forceDelete(User $user, Banque $banque): bool
    {
        if ($user->can(config('gate.banque.delete'))) {
            return $user->can(config('gate.banque.list-own')) ? self::userCheck($user, $banque) : true;
        } else {
            return false;
        }
    }
}
