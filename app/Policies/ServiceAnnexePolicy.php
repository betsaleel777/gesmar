<?php

namespace App\Policies;

use App\Models\Architecture\ServiceAnnexe;
use App\Models\User;
use App\Traits\HasPolicyFilter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use ReflectionClass;

class ServiceAnnexePolicy
{
    use HandlesAuthorization, HasPolicyFilter;

    private static function userCheck(User $user, ServiceAnnexe $annexe): bool
    {
        return $annexe->load('shortAudit')->shortAudit->user_id === $user->id;
    }

    private static function checkPermissionWithOwner(User $user, ServiceAnnexe $annexe, string $action): bool
    {
        $name = str((new ReflectionClass($annexe))->getShortName())->lower();
        if ($user->can(config("gate.$name.$action"))) {
            return $user->can(config("gate.$name.list-own")) ? self::userCheck($user, $annexe) : true;
        } else {
            return false;
        }
    }

    public function viewAny(User $user): Response
    {
        return $user->can(config('gate.annexe.list-global')) ? Response::allow() : Response::deny();
    }

    public function view(User $user, ServiceAnnexe $serviceAnnexe)
    {
        return self::checkPermissionWithOwner($user, $serviceAnnexe, 'show');
    }

    public function create(User $user): bool
    {
        return $user->can(config('gate.annexe.create')) ? true : false;
    }

    public function update(User $user, ServiceAnnexe $serviceAnnexe)
    {
        return self::checkPermissionWithOwner($user, $serviceAnnexe, 'edit');
    }

    public function delete(User $user, ServiceAnnexe $serviceAnnexe)
    {
        return self::checkPermissionWithOwner($user, $serviceAnnexe, 'trash');
    }

    public function restore(User $user, ServiceAnnexe $serviceAnnexe)
    {
        return self::checkPermissionWithOwner($user, $serviceAnnexe, 'restore');
    }

    public function forceDelete(User $user, ServiceAnnexe $serviceAnnexe)
    {
        return self::checkPermissionWithOwner($user, $serviceAnnexe, 'delete');
    }
}
