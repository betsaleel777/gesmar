<?php

namespace App\Policies;

use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Response;
use ReflectionClass;

class UserPolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    private static function userCheck(User $user, User $model): bool
    {
        return $model->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    private static function checkPermissionWithOwner(User $user, User $model, string $action): bool | Response
    {
        $name = str((new ReflectionClass($model))->getShortName())->lower();
        if ($user->can(config("gate.$name.$action"))) {
            return $user->can(config("gate.$name.list-own")) ? self::userCheck($user, $model) : true;
        } else {
            return Response::deny("Action non permise sur cette ressource.");
        }
    }

    public function viewAny(User $user)
    {
        $user->can(config('gate.user.list-global')) ? Response::allow() : Response::deny("Accès interdit à la liste des utilisateurs.");
    }

    public function view(User $user, User $model): bool
    {
        return self::checkPermissionWithOwner($user, $model, 'show') or self::checkPermissionWithOwner($user, $model, 'edit');
    }

    public function create(User $user): bool
    {
        return $user->can(config('gate.user.create')) ? true : false;
    }

    public function update(User $user, User $model): bool
    {
        return self::checkPermissionWithOwner($user, $model, 'edit');
    }

    public function delete(User $user, User $model): bool
    {
        return self::checkPermissionWithOwner($user, $model, 'trash');
    }

    public function restore(User $user, User $model): bool
    {
        return self::checkPermissionWithOwner($user, $model, 'restore');
    }

    public function forceDelete(User $user, User $model): bool
    {
        return self::checkPermissionWithOwner($user, $model, 'delete');
    }

    public function attribuate(User $user, User $model): bool
    {
        return self::checkPermissionWithOwner($user, $model, 'attribuate-role');
    }
}
