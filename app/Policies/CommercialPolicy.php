<?php

namespace App\Policies;

use App\Models\Bordereau\Commercial;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Response;

class CommercialPolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    private static function userCheck(User $user, Commercial $commercial): bool
    {
        return $commercial->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    public function viewAny(User $user): Response
    {
        return $user->can(config('gate.commercial.list-global')) ? Response::allow() : Response::deny();
    }

    public function view(User $user, Commercial $commercial): bool
    {
        if ($user->can(config('gate.commercial.show')) or $user->can(config('gate.commercial.edit'))) {
            return $user->can(config('gate.commercial.list-own')) ? self::userCheck($user, $commercial) : true;
        } else {
            return false;
        }
    }

    public function create(User $user): bool
    {
        return $user->can(config('gate.commercial.create')) ? true : false;
    }

    public function update(User $user, Commercial $commercial): bool
    {
        if ($user->can(config('gate.commercial.edit'))) {
            return $user->can(config('gate.commercial.list-own')) ? self::userCheck($user, $commercial) : true;
        } else {
            return false;
        }
    }

    public function delete(User $user, Commercial $commercial): bool
    {
        if ($user->can(config('gate.commercial.trash'))) {
            return $user->can(config('gate.commercial.list-own')) ? self::userCheck($user, $commercial) : true;
        } else {
            return false;
        }
    }

    public function restore(User $user, Commercial $commercial): bool
    {
        if ($user->can(config('gate.commercial.restore'))) {
            return $user->can(config('gate.commercial.list-own')) ? self::userCheck($user, $commercial) : true;
        } else {
            return false;
        }
    }

    public function attribuate(User $user, Commercial $commercial): bool
    {
        if ($user->can(config('gate.commercial.attribuate'))) {
            return $user->can(config('gate.commercial.list-own')) ? self::userCheck($user, $commercial) : true;
        } else {
            return false;
        }
    }
}
