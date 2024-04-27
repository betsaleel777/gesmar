<?php

namespace App\Policies;

use App\Models\Bordereau\Bordereau;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use ReflectionClass;
use Response;

class BordereauPolicy
{
    use HandlesAuthorization;

    private static function userCheck(User $user, Bordereau $bordereau): bool
    {
        return $bordereau->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    private static function checkPermissionWithOwner(User $user, Bordereau $bordereau, string $action): bool | Response
    {
        $name = str((new ReflectionClass($bordereau))->getShortName())->lower();
        if ($user->can(config("gate.$name.$action"))) {
            return $user->can(config("gate.$name.list-own")) ? self::userCheck($user, $bordereau) : true;
        } else {
            return Response::deny("Action non permise sur cette ressource.");
        }
    }

    public function viewAny(User $user): Response
    {
        return $user->can(config('gate.bordereau.list-global')) ? Response::allow() : Response::deny("Accès interdit à la liste des bordereaux");
    }

    public function view(User $user, Bordereau $bordereau): bool
    {
        return self::checkPermissionWithOwner($user, $bordereau, 'show') or self::checkPermissionWithOwner($user, $bordereau, 'edit');
    }

    public function update(User $user, Bordereau $bordereau): bool
    {
        return self::checkPermissionWithOwner($user, $bordereau, 'edit');
    }
}
