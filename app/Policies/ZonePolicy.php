<?php

namespace App\Policies;

use App\Models\Architecture\Zone;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use ReflectionClass;

class ZonePolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    private static function userCheck(User $user, Zone $zone): bool
    {
        return $zone->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    private static function checkPermissionWithOwner(User $user, Zone $zone, string $action): bool | Response
    {
        $name = str((new ReflectionClass($zone))->getShortName())->lower();
        if ($user->can(config("gate.$name.$action"))) {
            return $user->can(config("gate.$name.list-own")) ? self::userCheck($user, $zone) : true;
        } else {
            return Response::deny("Action non permise sur cette ressource.");
        }
    }

    public function viewAny(User $user)
    {
        $user->can(config('gate.zone.list-global')) ? Response::allow() : Response::deny("Accès interdit à la liste des zones.");
    }

    public function view(User $user, Zone $zone): bool
    {
        return self::checkPermissionWithOwner($user, $zone, 'show') or self::checkPermissionWithOwner($user, $zone, 'edit');
    }

    public function create(User $user): bool
    {
        return $user->can(config('gate.zone.create')) ? true : false;
    }

    public function update(User $user, Zone $zone): bool
    {
        return self::checkPermissionWithOwner($user, $zone, 'edit');
    }

    public function delete(User $user, Zone $zone): bool
    {
        return self::checkPermissionWithOwner($user, $zone, 'trash');
    }

    public function restore(User $user, Zone $zone): bool
    {
        return self::checkPermissionWithOwner($user, $zone, 'restore');
    }

    public function forceDelete(User $user, Zone $zone): bool
    {
        return self::checkPermissionWithOwner($user, $zone, 'delete');
    }
}
