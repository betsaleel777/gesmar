<?php

namespace App\Http\Controllers\Parametre;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    public function all(): JsonResponse
    {
        $permissions = Permission::get();

        return response()->json(['permissions' => $permissions]);
    }

    public function show(int $id): JsonResponse
    {
        $permission = Permission::with('roles')->find($id);

        return response()->json(['permission' => $permission]);
    }
}
