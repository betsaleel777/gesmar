<?php

namespace App\Http\Controllers\Parametre;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;

class PermissionsController extends Controller
{
    public function all(): JsonResponse
    {
        $this->authorize('viewAny', Permission::class);
        $permissions = Permission::get();
        return response()->json(['permissions' => $permissions]);
    }

    public function show(int $id): JsonResponse
    {
        $permission = Permission::with('roles')->find($id);
        $this->authorize('view', $permission);
        return response()->json(['permission' => $permission]);
    }

    public function getByRole(int $id): JsonResponse
    {
        $role = Role::with(['permissions' => fn($query) => $query->select('id', 'name')])->find($id);
        return response()->json(['permissions' => $role->permissions]);
    }
}
