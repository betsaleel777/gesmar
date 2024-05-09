<?php

namespace App\Policies;

use App\Models\Exploitation\Contrat;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ContratPolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    private static function userCheck(User $user, Contrat $contrat): bool
    {
        return $contrat->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    public function viewAny(User $user): Response
    {
        return $user->can(config('gate.contrat.list-global')) ? Response::allow() : Response::deny();
    }

    public function viewValidAny(User $user): Response
    {
        return $user->can(config('gate.contrat.list-valid-global')) ? Response::allow() : Response::deny();
    }

    public function viewValid(User $user, Contrat $contrat): bool
    {
        if ($user->can(config('gate.contrat.valid-show')) or $user->can(config('gate.contrat.valid-show'))) {
            return $user->can(config('gate.contrat.list-valid-own')) ? self::userCheck($user, $contrat) : true;
        } else {
            return false;
        }
    }

    public function view(User $user, Contrat $contrat): bool
    {
        if ($user->can(config('gate.contrat.show')) or $user->can(config('gate.contrat.show'))) {
            return $user->can(config('gate.contrat.list-own')) ? self::userCheck($user, $contrat) : true;
        } else {
            return false;
        }
    }

    public function create(User $user)
    {
        return $user->can(config('gate.contrat.create')) ? true : false;
    }

    public function update(User $user, Contrat $contrat): bool
    {
        if ($user->can(config('gate.contrat.edit'))) {
            return $user->can(config('gate.contrat.list-own')) ? self::userCheck($user, $contrat) : true;
        } else {
            return false;
        }
    }

    public function delete(User $user, Contrat $contrat): bool
    {
        if ($user->can(config('gate.contrat.trash'))) {
            return $user->can(config('gate.contrat.list-own')) ? self::userCheck($user, $contrat) : true;
        } else {
            return false;
        }
    }

    public function restore(User $user, Contrat $contrat): bool
    {
        if ($user->can(config('gate.restore.trash'))) {
            return $user->can(config('gate.contrat.list-own')) ? self::userCheck($user, $contrat) : true;
        } else {
            return false;
        }
    }

    public function forceDelete(User $user, Contrat $contrat): bool
    {
        if ($user->can(config('gate.contrat.delete'))) {
            return $user->can(config('gate.contrat.list-own')) ? self::userCheck($user, $contrat) : true;
        } else {
            return false;
        }
    }

    public function schedule(User $user, Contrat $contrat): bool
    {
        if ($user->can(config('gate.contrat.schedule'))) {
            return $user->can(config('gate.contrat.list-own')) ? self::userCheck($user, $contrat) : true;
        } else {
            return false;
        }
    }

    public function endorse(User $user, Contrat $contrat): bool
    {
        if ($user->can(config('gate.contrat.endorse'))) {
            return $user->can(config('gate.contrat.list-own')) ? self::userCheck($user, $contrat) : true;
        } else {
            return false;
        }
    }

    public function validate(User $user, Contrat $contrat): bool
    {
        if ($user->can(config('gate.contrat.validate'))) {
            return $user->can(config('gate.contrat.list-own')) ? self::userCheck($user, $contrat) : true;
        } else {
            return false;
        }
    }
}
