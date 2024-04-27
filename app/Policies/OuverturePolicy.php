<?php

namespace App\Policies;

use App\Models\Caisse\Ouverture;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Response;
use ReflectionClass;

class OuverturePolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    private static function userCheck(User $user, Ouverture $ouverture): bool
    {
        return $ouverture->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    private static function checkPermissionWithOwner(User $user, Ouverture $ouverture, string $action): bool | Response
    {
        $name = str((new ReflectionClass($ouverture))->getShortName())->lower();
        if ($user->can(config("gate.$name.$action"))) {
            return $user->can(config("gate.$name.list-own")) ? self::userCheck($user, $ouverture) : true;
        } else {
            return Response::deny("Action non permise sur cette ressource.");
        }
    }

    public function viewAny(User $user): Response
    {
        return $user->can(config('gate.ouverture.list-global')) ? Response::allow() : Response::deny("Accès interdit à la liste des ouvertures de caisse.");
    }

    public function view(User $user, Ouverture $ouverture)
    {
        return self::checkPermissionWithOwner($user, $ouverture, 'show') or self::checkPermissionWithOwner($user, $ouverture, 'edit');
    }

    public function create(User $user): bool
    {
        return $user->can(config('gate.ouverture.create')) ? true : false;
    }

    public function update(User $user, Ouverture $ouverture)
    {
        return self::checkPermissionWithOwner($user, $ouverture, 'edit');
    }
}
