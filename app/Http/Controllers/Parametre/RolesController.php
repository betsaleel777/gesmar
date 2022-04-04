<?php

namespace App\Http\Controllers\Parametre;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{

    public function all()
    {
        $roles = Role::with('permissions')->get();
        return response()->json(['roles' => $roles]);
    }

    public function show(int $id)
    {
        $role = Role::with('permissions')->find($id);
        return response()->json(['role' => $role]);
    }

    public function store(Request $request)
    {
        $rules = ['name' => 'required|unique:roles,name'];
        $this->validate($request, $rules);
        $role = new Role();
        $role->name = $request->name;
        $role->save();
        $role = Role::find($role->id);
        if (!empty($request->permissions)) {
            $role->syncPermissions($request->permissions);
        }
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
        if (!empty($request->permissions)) {
            $role->syncPermissions($request->permissions);
        }
        $message = "Le rôle a été modifié avec succès.";
        return response()->json(['message' => $message]);
    }
}
