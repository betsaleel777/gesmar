<?php

namespace App\Policies;

use App\Models\Exploitation\Personne;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Response;
use ReflectionClass;

class PersonnePolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    private static function userCheck(User $user, Personne $personne): bool
    {
        return $personne->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    private static function checkPermissionWithOwner(User $user, Personne $personne, string $action): bool | Response
    {
        $name = str((new ReflectionClass($personne))->getShortName())->lower();
        if ($user->can(config("gate.$name.$action"))) {
            return $user->can(config("gate.$name.list-own")) ? self::userCheck($user, $personne) : true;
        } else {
            return Response::deny("Action non permise sur cette ressource.");
        }
    }

    public function viewAny(User $user): Response
    {
        return $user->can(config('gate.personne.list-global')) ? Response::allow() : Response::deny();
    }

    public function view(User $user, Personne $personne): bool | Response
    {
        return self::checkPermissionWithOwner($user, $personne, 'show') or self::checkPermissionWithOwner($user, $personne, 'edit');
    }

    public function create(User $user)
    {
        return $user->can(config('gate.personne.create')) ? true : false;
    }

    public function update(User $user, Personne $personne): bool | Response
    {
        return self::checkPermissionWithOwner($user, $personne, 'edit');
    }

    public function delete(User $user, Personne $personne): bool | Response
    {
        return self::checkPermissionWithOwner($user, $personne, 'trash');
    }

    public function restore(User $user, Personne $personne): bool | Response
    {
        return self::checkPermissionWithOwner($user, $personne, 'restore');
    }

    public function forceDelete(User $user, Personne $personne): bool | Response
    {
        return self::checkPermissionWithOwner($user, $personne, 'delete');
    }
}
