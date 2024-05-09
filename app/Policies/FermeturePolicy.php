<?php

namespace App\Policies;

use App\Models\Caisse\Fermeture;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Response;
use ReflectionClass;

class FermeturePolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    private static function userCheck(User $user, Fermeture $fermeture): bool
    {
        return $fermeture->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    private static function checkPermissionWithOwner(User $user, Fermeture $fermeture, string $action): bool | Response
    {
        $name = str((new ReflectionClass($fermeture))->getShortName())->lower();
        if ($user->can(config("gate.$name.$action"))) {
            return $user->can(config("gate.$name.list-own")) ? self::userCheck($user, $fermeture) : true;
        } else {
            return Response::deny("Action non permise sur cette ressource.");
        }
    }

    public function viewAny(User $user): Response
    {
        return $user->can(config('gate.point-caisse.list-global')) ? Response::allow() : Response::deny();
    }

    public function view(User $user, Fermeture $fermeture): bool | Response
    {
        return self::checkPermissionWithOwner($user, $fermeture, 'show') or
        self::checkPermissionWithOwner($user, $fermeture, 'edit');
    }

    public function create(User $user): bool
    {
        return $user->can(config('gate.fermeture.create')) ? true : false;
    }
}
