<?php

namespace App\Http\Controllers\Parametre;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $roles = Role::with('permissions')->get();
        $titre = 'Rôles';
        return view('parametre.role.index', compact('roles', 'titre'));
    }

    public function show(int $id)
    {
        $role = Role::with('permissions')->find($id);
        return view('parametre.role.show', compact('roles', 'titre'));
    }

    public function add()
    {
        $titre = 'Créer un rôle';
        $permissions = Permission::get();
        return view('parametre.role.add', compact('titre', 'permissions'));
    }

    public function insert(Request $request)
    {
        $rules = ['name' => 'required|unique:roles,name'];
        $this->validate($request, $rules);
        $data = Role::create($request->all());
        $role = Role::find($data->id);
        $role->syncPermissions($request->permissions);
        $message = "Le rôle $request->name a été crée avec succès.";
        return redirect()->route('admin.role.index')->with('success', $message);
    }

    public function update(int $id, Request $request)
    {
        $rules = ['name' => 'required|unique:roles,name,' . $id];
        $this->validate($request, $rules);
        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permissions);
        $message = "Le rôle a été modifié avec succès.";
        return redirect()->route('admin.role.index')->with('success', $message);
    }
}
