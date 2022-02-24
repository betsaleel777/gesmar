<?php

namespace App\Http\Controllers\Parametre;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return response()->json(['roles' => $roles]);
    }

    public function show(int $id)
    {
        $role = Role::with('permissions')->find($id);
        return response()->json(['role' => $role]);
    }

    public function insert(Request $request)
    {
        $rules = ['name' => 'required|unique:roles,name'];
        $this->validate($request, $rules);
        Role::create($request->all());
        $message = "Le rôle $request->name a été crée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function update(int $id, Request $request)
    {
        $rules = ['name' => 'required|unique:roles,name,' . $id];
        $this->validate($request, $rules);
        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();
        $message = "Le rôle a été modifié avec succès.";
        return response()->json(['message' => $message]);
    }

    public function assign(Request $request)
    {
        $role = Role::find($request->id);
        $role->syncPermissions($request->permissions);
        $message = "Les permissions ont été correctements assignées au rôle $role->name.";
        return response()->json(['message' => $message]);
    }

    public function permissions()
    {
        $permissions = Permission::get();
        return response()->json(['permissions' => $permissions]);
    }
}
