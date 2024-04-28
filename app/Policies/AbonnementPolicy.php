<?php

namespace App\Policies;

use App\Models\Architecture\Abonnement;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AbonnementPolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    private static function userCheck(User $user, Abonnement $abonnement): bool
    {
        return $abonnement->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    public function viewAny(User $user): Response
    {
        return $user->can(config('gate.abonnement.list-global')) ? Response::allow() : Response::deny();
    }

    public function view(User $user, Abonnement $abonnement): bool
    {
        if ($user->can(config('gate.abonnement.show')) or $user->can(config('gate.abonnement.edit'))) {
            return $user->can(config('gate.abonnement.list-own')) ? self::userCheck($user, $abonnement) : true;
        } else {
            return Response::deny("La visualisation des abonnements est non permise.");
        }
    }

    public function create(User $user): bool | Response
    {
        return $user->can(config('gate.abonnement.create')) ? true : Response::deny("La création d'abonnement est non permise.");
    }

    public function update(User $user, Abonnement $abonnement): bool | Response
    {
        if ($user->can(config('gate.abonnement.edit'))) {
            return $user->can(config('gate.abonnement.list-own')) ? self::userCheck($user, $abonnement) : true;
        } else {
            return Response::deny("La modification des abonnements est non permise.");
        }
    }

    public function delete(User $user, Abonnement $abonnement): bool | Response
    {
        if ($user->can(config('gate.abonnement.trash'))) {
            return $user->can(config('gate.abonnement.list-own')) ? self::userCheck($user, $abonnement) : true;
        } else {
            return Response::deny("L'archivage des abonnements est non permise.");
        }
    }

    public function abort(User $user, Abonnement $abonnement): bool | Response
    {
        if ($user->can(config('gate.abonnement.abort'))) {
            return $user->can(config('gate.abonnement.list-own')) ? self::userCheck($user, $abonnement) : true;
        } else {
            return Response::deny("La résiliation des abonnements est non permise.");
        }
    }

    public function restore(User $user, Abonnement $abonnement): bool | Response
    {
        if ($user->can(config('gate.abonnement.restore'))) {
            return $user->can(config('gate.abonnement.list-own')) ? self::userCheck($user, $abonnement) : true;
        } else {
            return Response::deny("La restauration des abonnements est non permise.");
        }
    }

    public function forceDelete(User $user, Abonnement $abonnement): bool | Response
    {
        if ($user->can(config('gate.abonnement.delete'))) {
            return $user->can(config('gate.abonnement.list-own')) ? self::userCheck($user, $abonnement) : true;
        } else {
            return Response::deny("La suppression définitive des abonnements est non permise.");
        }
    }
}
