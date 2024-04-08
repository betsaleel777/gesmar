<?php

namespace App\Policies;

use App\Models\Exploitation\TypePersonne;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Response;
use ReflectionClass;

class TypePersonnePolicy
{
    use HandlesAuthorization;

    private static function userCheck(User $user, TypePersonne $type): bool
    {
        return $type->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    private static function checkPermissionWithOwner(User $user, TypePersonne $type, string $action): bool
    {
        $name = str((new ReflectionClass($type))->getShortName())->lower();
        if ($user->can(config("gate.$name.$action"))) {
            return $user->can(config("gate.$name.list-own")) ? self::userCheck($user, $type) : true;
        } else {
            return false;
        }
    }

    public function viewAny(User $user): Response
    {
        return $user->can(config('gate.type-personne.list-global')) ? Response::allow() : Response::deny();
    }

    public function view(User $user, TypePersonne $type): bool
    {
        return self::checkPermissionWithOwner($user, $type, 'show');
    }

    public function create(User $user): bool
    {
        return $user->can(config('gate.type-personne.create')) ? true : false;
    }

    public function update(User $user, TypePersonne $type): bool
    {
        return self::checkPermissionWithOwner($user, $type, 'edit');
    }

    public function delete(User $user, TypePersonne $type): bool
    {
        return self::checkPermissionWithOwner($user, $type, 'trash');
    }

    public function restore(User $user, TypePersonne $type): bool
    {
        return self::checkPermissionWithOwner($user, $type, 'restore');
    }

    public function forceDelete(User $user, TypePersonne $type): bool
    {
        return self::checkPermissionWithOwner($user, $type, 'delete');
    }
}
