<?php

namespace App\Http\Controllers\Parametre;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function all(): JsonResponse
    {
        $this->authorize('viewAny', Role::class);
        $roles = Role::get();
        return response()->json(['roles' => $roles]);
    }

    public function show(int $id): JsonResponse
    {
        $role = Role::with('permissions')->findOrFail($id);
        $this->authorize('view', Role::class);
        return response()->json(['role' => $role]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Role::class);
        $rules = ['name' => 'required|unique:roles,name', 'permissions' => 'required|array'];
        $this->validate($request, $rules);
        $role = new Role();
        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permissions);
        $message = "Le rôle $request->name a été crée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $this->authorize('update', Role::class);
        $role = Role::findOrFail($id);
        $rules = ['name' => 'required|unique:roles,name,' . $id, 'permissions' => 'required|array'];
        $this->validate($request, $rules);
        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permissions);
        $message = 'Le rôle a été modifié avec succès.';
        return response()->json(['message' => $message]);
    }
}
