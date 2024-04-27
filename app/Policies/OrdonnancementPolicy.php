<?php

namespace App\Policies;

use App\Models\Exploitation\Ordonnancement;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Response;
use ReflectionClass;

class OrdonnancementPolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    private static function userCheck(User $user, Ordonnancement $ordonnancement): bool
    {
        return $ordonnancement->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    private static function checkPermissionWithOwner(User $user, Ordonnancement $ordonnancement, string $action): bool | Response
    {
        $name = str((new ReflectionClass($ordonnancement))->getShortName())->lower();
        if ($user->can(config("gate.$name.$action"))) {
            return $user->can(config("gate.$name.list-own")) ? self::userCheck($user, $ordonnancement) : true;
        } else {
            return Response::deny("Action non permise sur cette ressource.");
        }
    }

    public function viewAny(User $user): Response
    {
        return $user->can(config('gate.ordonnancement.list-global')) ? Response::allow() : Response::deny("Accès interdit à la liste des ordonnancements.");
    }

    public function view(User $user, Ordonnancement $ordonnancement): bool
    {
        return self::checkPermissionWithOwner($user, $ordonnancement, 'show') or
        self::checkPermissionWithOwner($user, $ordonnancement, 'edit');
    }
}
