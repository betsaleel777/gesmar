<?php

namespace App\Policies;

use App\Models\Architecture\Niveau;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use ReflectionClass;

class NiveauPolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    private static function userCheck(User $user, Niveau $niveau): bool
    {
        return $niveau->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    private static function checkPermissionWithOwner(User $user, Niveau $niveau, string $action): bool
    {
        $name = str((new ReflectionClass($niveau))->getShortName())->lower();
        if ($user->can(config("gate.$name.$action"))) {
            return $user->can(config("gate.$name.list-own")) ? self::userCheck($user, $niveau) : true;
        } else {
            return false;
        }
    }

    public function viewAny(User $user)
    {
        $user->can(config('gate.niveau.list-global')) ? Response::allow() : Response::deny();
    }

    public function view(User $user, Niveau $niveau): bool
    {
        return self::checkPermissionWithOwner($user, $niveau, 'show');
    }

    public function create(User $user): bool
    {
        return $user->can(config('gate.niveau.create')) ? true : false;
    }

    public function update(User $user, Niveau $niveau): bool
    {
        return self::checkPermissionWithOwner($user, $niveau, 'edit');
    }

    public function delete(User $user, Niveau $niveau): bool
    {
        return self::checkPermissionWithOwner($user, $niveau, 'trash');
    }

    public function restore(User $user, Niveau $niveau): bool
    {
        return self::checkPermissionWithOwner($user, $niveau, 'restore');
    }
}
