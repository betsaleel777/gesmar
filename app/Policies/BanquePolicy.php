<?php

namespace App\Policies;

use App\Models\Caisse\Banque;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BanquePolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    private static function userCheck(User $user, Banque $banque): bool
    {
        return $banque->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    public function viewAny(User $user): Response
    {
        return $user->can(config('gate.banque.list-global')) ? Response::allow() : Response::deny("Accès interdit à la liste des banques.");
    }

    public function create(User $user): bool | Response
    {
        return $user->can(config('gate.banque.create')) ? true : Response::deny("La création de la banque est non permise.");
    }

    public function update(User $user, Banque $banque): bool | Response
    {
        if ($user->can(config('gate.banque.edit'))) {
            return $user->can(config('gate.banque.list-own')) ? self::userCheck($user, $banque) : true;
        } else {
            return Response::deny("La modification de la banque est non permise.");
        }
    }

    public function delete(User $user, Banque $banque): bool | Response
    {
        if ($user->can(config('gate.banque.trash'))) {
            return $user->can(config('gate.banque.list-own')) ? self::userCheck($user, $banque) : true;
        } else {
            return Response::deny("L'archivage de la banque est non permise.");
        }
    }

    public function restore(User $user, Banque $banque): bool | Response
    {
        if ($user->can(config('gate.banque.restore'))) {
            return $user->can(config('gate.banque.list-own')) ? self::userCheck($user, $banque) : true;
        } else {
            return Response::deny("La restauration de la banque est non permise.");
        }
    }

    public function forceDelete(User $user, Banque $banque): bool | Response
    {
        if ($user->can(config('gate.banque.delete'))) {
            return $user->can(config('gate.banque.list-own')) ? self::userCheck($user, $banque) : true;
        } else {
            return Response::deny("La suppression définitive de la banque est non permise.");
        }
    }
}
