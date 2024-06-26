<?php

namespace App\Policies;

use App\Models\Exploitation\TypePersonne;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Response;
use ReflectionClass;

class TypePersonnePolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    private static function userCheck(User $user, TypePersonne $type): bool
    {
        return $type->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    private static function checkPermissionWithOwner(User $user, TypePersonne $type, string $action): bool | Response
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
        return $user->can(config('gate.type-personne.list-global')) ? Response::allow() : Response::deny();
    }

    public function create(User $user): bool
    {
        return $user->can(config('gate.type-personne.create')) ? true : false;
    }

    public function update(User $user, TypePersonne $type): bool | Response
    {
        return self::checkPermissionWithOwner($user, $type, 'edit');
    }

    public function delete(User $user, TypePersonne $type): bool | Response
    {
        return self::checkPermissionWithOwner($user, $type, 'trash');
    }

    public function restore(User $user, TypePersonne $type): bool | Response
    {
        return self::checkPermissionWithOwner($user, $type, 'restore');
    }

    public function forceDelete(User $user, TypePersonne $type): bool | Response
    {
        return self::checkPermissionWithOwner($user, $type, 'delete');
    }
}
