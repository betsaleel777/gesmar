<?php

namespace App\Policies;

use App\Models\Architecture\Pavillon;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use ReflectionClass;

class PavillonPolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    private static function userCheck(User $user, Pavillon $pavillon): bool
    {
        return $pavillon->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    private static function checkPermissionWithOwner(User $user, Pavillon $pavillon, string $action): bool | Response
    {
        $name = str((new ReflectionClass($pavillon))->getShortName())->lower();
        if ($user->can(config("gate.$name.$action"))) {
            return $user->can(config("gate.$name.list-own")) ? self::userCheck($user, $pavillon) : true;
        } else {
            return Response::deny("Action non permise sur cette ressource.");
        }
    }

    public function viewAny(User $user): response
    {
        return $user->can(config('gate.pavillon.list-global')) ? Response::allow() : Response::deny("Accès interdit à la liste des pavillons.");
    }

    public function view(User $user, Pavillon $pavillon)
    {
        return self::checkPermissionWithOwner($user, $pavillon, 'show') or self::checkPermissionWithOwner($user, $pavillon, 'edit');
    }

    public function create(User $user): bool
    {
        return $user->can(config('gate.pavillon.create')) ? true : false;
    }

    public function update(User $user, Pavillon $pavillon)
    {
        return self::checkPermissionWithOwner($user, $pavillon, 'edit');
    }

    public function delete(User $user, Pavillon $pavillon)
    {
        return self::checkPermissionWithOwner($user, $pavillon, 'trash');
    }

    public function restore(User $user, Pavillon $pavillon)
    {
        return self::checkPermissionWithOwner($user, $pavillon, 'restore');
    }

    public function forceDelete(User $user, Pavillon $pavillon)
    {
        return self::checkPermissionWithOwner($user, $pavillon, 'delete');
    }
}
