<?php

namespace App\Policies;

use App\Models\Caisse\Encaissement;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Response;
use ReflectionClass;

class EncaissementPolicy
{
    use HandlesAuthorization;

    private static function userCheck(User $user, Encaissement $encaissement): bool
    {
        return $encaissement->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    private static function checkPermissionWithOwner(User $user, Encaissement $encaissement, string $action): bool
    {
        $name = str((new ReflectionClass($encaissement))->getShortName())->lower();
        if ($user->can(config("gate.$name.$action"))) {
            return $user->can(config("gate.$name.list-own")) ? self::userCheck($user, $encaissement) : true;
        } else {
            return false;
        }
    }

    public function viewAny(User $user): Response
    {
        return $user->can(config('gate.encaissement.list-global')) ? Response::allow() : Response::deny();
    }

    public function view(User $user, Encaissement $encaissement)
    {
        return self::checkPermissionWithOwner($user, $encaissement, 'show');
    }

    public function create(User $user)
    {
        return $user->can(config('gate.encaissement.create')) ? true : false;
    }
}
