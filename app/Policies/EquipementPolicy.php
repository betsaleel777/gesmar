<?php

namespace App\Policies;

use App\Models\Architecture\Equipement;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use ReflectionClass;

class EquipementPolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    private static function userCheck(User $user, Equipement $equipement): bool
    {
        return $equipement->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    private static function checkPermissionWithOwner(User $user, Equipement $equipement, string $action): bool | Response
    {
        $name = str((new ReflectionClass($equipement))->getShortName())->lower();
        if ($user->can(config("gate.$name.$action"))) {
            return $user->can(config("gate.$name.list-own")) ? self::userCheck($user, $equipement) : true;
        } else {
            return Response::deny("Action non permise sur cette ressource.");
        }
    }

    public function viewAny(User $user): Response
    {
        return $user->can(config('gate.equipement.list-global')) ? Response::allow() : Response::deny("Accès interdit à la liste des équipements");
    }

    public function view(User $user, Equipement $equipement): bool
    {
        return self::checkPermissionWithOwner($user, $equipement, 'show') or self::checkPermissionWithOwner($user, $equipement, 'edit');
    }

    public function create(User $user)
    {
        return $user->can(config('gate.equipement.create')) ? true : false;
    }

    public function update(User $user, Equipement $equipement): bool
    {
        return self::checkPermissionWithOwner($user, $equipement, 'edit');
    }

    public function delete(User $user, Equipement $equipement): bool
    {
        return self::checkPermissionWithOwner($user, $equipement, 'trash');
    }

    public function restore(User $user, Equipement $equipement): bool
    {
        return self::checkPermissionWithOwner($user, $equipement, 'restore');
    }

    public function forceDelete(User $user, Equipement $equipement): bool
    {
        return self::checkPermissionWithOwner($user, $equipement, 'delete');
    }
}
