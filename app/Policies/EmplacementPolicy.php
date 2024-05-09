<?php

namespace App\Policies;

use App\Models\Architecture\Emplacement;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use ReflectionClass;

class EmplacementPolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    private static function userCheck(User $user, Emplacement $emplacement): bool
    {
        return $emplacement->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    private static function checkPermissionWithOwner(User $user, Emplacement $emplacement, string $action): bool | Response
    {
        $name = str((new ReflectionClass($emplacement))->getShortName())->lower();
        if ($user->can(config("gate.$name.$action"))) {
            return $user->can(config("gate.$name.list-own")) ? self::userCheck($user, $emplacement) : true;
        } else {
            return Response::deny("Action non permise sur cette ressource.");
        }
    }

    public function viewAny(User $user): Response
    {
        return $user->can(config('gate.emplacement.list-global')) ? Response::allow() : Response::deny();
    }

    public function view(User $user, Emplacement $emplacement): bool | Response
    {
        return self::checkPermissionWithOwner($user, $emplacement, 'show') or self::checkPermissionWithOwner($user, $emplacement, 'edit');
    }

    public function create(User $user): bool
    {
        return $user->can(config('gate.emplacement.create')) ? true : false;
    }

    public function update(User $user, Emplacement $emplacement): bool | Response
    {
        return self::checkPermissionWithOwner($user, $emplacement, 'edit');
    }

    public function delete(User $user, Emplacement $emplacement): bool | Response
    {
        return self::checkPermissionWithOwner($user, $emplacement, 'trash');
    }

    public function restore(User $user, Emplacement $emplacement): bool | Response
    {
        return self::checkPermissionWithOwner($user, $emplacement, 'restore');
    }

    public function forceDelete(User $user, Emplacement $emplacement): bool | Response
    {
        return self::checkPermissionWithOwner($user, $emplacement, 'delete');
    }
}
