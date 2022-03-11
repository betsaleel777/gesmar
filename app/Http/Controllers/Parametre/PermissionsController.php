<?php

namespace App\Http\Controllers\Parametre;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    public function index()
    {
        $permissions = Permission::get();
        $titre = 'Permissions';
        return view('parametre.permission.index', compact('permissions', 'titre'));
    }

    public function show(int $id)
    {
        $permission = Permission::with('roles')->find($id);
        $titre = $permission->name;
        return view('parametre.permission.show', compact('permission', 'titre'));
    }
}
