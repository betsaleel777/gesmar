<?php

namespace App\Policies;

use App\Models\Architecture\TypeEquipement;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use ReflectionClass;

class TypeEquipementPolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    private static function userCheck(User $user, TypeEquipement $type): bool
    {
        return $type->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    private static function checkPermissionWithOwner(User $user, TypeEquipement $type, string $action): bool | Response
    {
        $name = str((new ReflectionClass($type))->getShortName())->snake('-');
        if ($user->can(config("gate.$name.$action"))) {
            return $user->can(config("gate.$name.list-own")) ? self::userCheck($user, $type) : true;
        } else {
            return Response::deny("Action non permise sur cette ressource.");
        }
    }

    public function viewAny(User $user): Response
    {
        return $user->can(config('gate.type-equipement.list-global')) ? Response::allow() : Response::deny();
    }

    public function create(User $user): bool
    {
        return $user->can(config('gate.type-equipement.create')) ? true : false;
    }

    public function update(User $user, TypeEquipement $type): bool | Response
    {
        return self::checkPermissionWithOwner($user, $type, 'edit');
    }

    public function delete(User $user, TypeEquipement $type): bool | Response
    {
        return self::checkPermissionWithOwner($user, $type, 'trash');
    }

    public function restore(User $user, TypeEquipement $type): bool | Response
    {
        return self::checkPermissionWithOwner($user, $type, 'restore');
    }

    public function forceDelete(User $user, TypeEquipement $type): bool | Response
    {
        return self::checkPermissionWithOwner($user, $type, 'delete');
    }
}
