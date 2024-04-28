<?php

namespace App\Policies;

use App\Models\Finance\Facture;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Response;
use ReflectionClass;

class FacturePolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    private static function userCheck(User $user, Facture $facture): bool
    {
        return $facture->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    private static function checkPermissionWithOwner(User $user, Facture $facture, string $categorie, string $action): bool | Response
    {
        $name = str((new ReflectionClass($facture))->getShortName())->lower();
        if ($user->can(config("gate.$name-$categorie.$action"))) {
            return $user->can(config("gate.$name-$categorie.list-own")) ? self::userCheck($user, $facture) : true;
        } else {
            return Response::deny("Action non permise sur cette ressource.");
        }
    }

    public function viewAny(User $user, string $categorie): Response
    {
        return $user->can(config("gate.facture-$categorie.list-global")) ? Response::allow() : Response::deny();
    }

    public function view(User $user, Facture $facture, string $categorie): bool | Response
    {
        return self::checkPermissionWithOwner($user, $facture, $categorie, 'show') or
        self::checkPermissionWithOwner($user, $facture, $categorie, 'edit');
    }

    public function create(User $user, string $categorie): bool
    {
        return $user->can(config("gate.facture-$categorie.create")) ? true : false;
    }

    public function update(User $user, Facture $facture, string $categorie): bool | Response
    {
        return self::checkPermissionWithOwner($user, $facture, $categorie, 'edit');
    }
}
