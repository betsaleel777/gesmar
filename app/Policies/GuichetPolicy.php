<?php

namespace App\Policies;

use App\Models\Caisse\Guichet;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use ReflectionClass;

class GuichetPolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    private static function userCheck(User $user, Guichet $guichet): bool
    {
        return $guichet->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    private static function checkPermissionWithOwner(User $user, Guichet $guichet, string $action): bool
    {
        $name = str((new ReflectionClass($guichet))->getShortName())->lower();
        if ($user->can(config("gate.$name.$action"))) {
            return $user->can(config("gate.$name.list-own")) ? self::userCheck($user, $guichet) : true;
        } else {
            return false;
        }
    }

    public function viewAny(User $user): Response
    {
        return $user->can(config('gate.guichet.list-global')) ? Response::allow() : Response::deny();
    }

    public function view(User $user, Guichet $guichet): bool
    {
        return self::checkPermissionWithOwner($user, $guichet, 'show');
    }

    public function create(User $user): bool
    {
        return $user->can(config('gate.guichet.create')) ? true : false;
    }

    public function update(User $user, Guichet $guichet): bool
    {
        return self::checkPermissionWithOwner($user, $guichet, 'edit');
    }

    public function delete(User $user, Guichet $guichet): bool
    {
        return self::checkPermissionWithOwner($user, $guichet, 'trash');
    }

    public function restore(User $user, Guichet $guichet): bool
    {
        return self::checkPermissionWithOwner($user, $guichet, 'restore');
    }

    public function forceDelete(User $user, Guichet $guichet): bool
    {
        return self::checkPermissionWithOwner($user, $guichet, 'delete');
    }
}
