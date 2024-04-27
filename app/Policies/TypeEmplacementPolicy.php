<?php

namespace App\Policies;

use App\Models\Architecture\TypeEmplacement;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use ReflectionClass;

class TypeEmplacementPolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    private static function userCheck(User $user, TypeEmplacement $type): bool
    {
        return $type->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    private static function checkPermissionWithOwner(User $user, TypeEmplacement $type, string $action): bool | Response
    {
        $name = str((new ReflectionClass($type))->getShortName())->lower();
        if ($user->can(config("gate.$name.$action"))) {
            return $user->can(config("gate.$name.list-own")) ? self::userCheck($user, $type) : true;
        } else {
            return Response::deny("Action non permise sur cette ressource.");
        }
    }

    public function viewAny(User $user): Response
    {
        return $user->can(config('gate.type-emplacement.list-global')) ? Response::allow() : Response::deny("Accès interdit à la liste des types d'emplacements");
    }

    public function view(User $user, TypeEmplacement $type): bool
    {
        return self::checkPermissionWithOwner($user, $type, 'show') or self::checkPermissionWithOwner($user, $type, 'edit');
    }

    public function create(User $user): bool
    {
        return $user->can(config('gate.type-emplacement.create')) ? true : false;
    }

    public function update(User $user, TypeEmplacement $type): bool
    {
        return self::checkPermissionWithOwner($user, $type, 'edit');
    }

    public function delete(User $user, TypeEmplacement $type): bool
    {
        return self::checkPermissionWithOwner($user, $type, 'trash');
    }

    public function restore(User $user, TypeEmplacement $type): bool
    {
        return self::checkPermissionWithOwner($user, $type, 'restore');
    }

    public function forceDelete(User $user, TypeEmplacement $type): bool
    {
        return self::checkPermissionWithOwner($user, $type, 'delete');
    }
}
