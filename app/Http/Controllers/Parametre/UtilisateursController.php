<?php

namespace App\Http\Controllers\Parametre;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UtilisateursController extends Controller
{
    public function all(): JsonResponse
    {
        $users = User::get();
        return response()->json(['users' => $users]);
    }

    public function trashed(): JsonResponse
    {
        $users = User::onlyTrashed()->get();
        return response()->json(['users' => $users]);
    }

    public function show(int $id): JsonResponse
    {
        $user = User::with(['roles', 'permissions'])->withTrashed()->findOrFail($id);
        $permissions = $user->getAllPermissions();
        return response()->json(['user' => $user, 'permissions' => $permissions]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(User::RULES);
        $user = new User($request->all());
        $user->password = Hash::make($request->password);
        $user->disconnect();
        $user->save();
        $path = substr($request->file('avatar')->store('public/user-' . $user->id), 7);
        $user->avatar = $path;
        $user->save();
        $message = "L'utilisateur $request->name a été crée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function profile(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), User::infosRules($request->id));
        $user = User::findOrFail($request->id);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        } else {
            $user->name = $request->name;
            $user->adresse = $request->adresse;
            $user->description = $request->description;
            if ($request->hasFile('image') and !empty($user->avatar)) {
                unlink(public_path() . '/storage/' . $user->avatar);
                $path = substr($request->file('image')->store('public/user-' . $request->id), 7);
                $user->avatar = $path;
            } else if ($request->hasFile('image') and empty($user->avatar)) {
                $path = substr($request->file('image')->store('public/user-' . $request->id), 7);
                $user->avatar = $path;
            }
            $user->save();
            $message = "Utilisateur a été modifié avec succes. \n
            Un rechargement de la page est nécessaire pour constater le rafraîchissement de l'image.";
            return response()->json(['message' => $message]);
        }
    }

    public function notifications(Request $request): JsonResponse
    {
        $message = '';
        return response()->json(['message' => $message]);
    }

    public function security(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), User::SECURITY_RULES);
        $user = User::findOrFail($request->id);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        } else {
            if (!Hash::check($request->oldPassword, $user->password)) {
                $message = 'Ancien mot de passe incorrecte.';
                return response()->json(['message' => $message], 400);
            } else {
                if (!empty($request->password)) {
                    $user->password = Hash::make($request->password);
                }
                $user->save();
                $message = 'Utilisateur a été modifié avec succes.';
                return response()->json(['message' => $message]);
            }
        }
    }

    public function autoriserDirect(Request $request): JsonResponse
    {
        $user = User::with('roles')->findOrFail($request->id);
        $rolePermissions = $user->getPermissionsViaRoles()->all();
        $message = '';
        // attribuer des permissions directes
        $directPermissions = [];
        if (count($rolePermissions) > 0) {
            $ids = array_column($rolePermissions, 'id');
            $directPermissions = array_filter($request->permissions, function ($permission) use ($ids) {
                return !in_array($permission['id'], $ids);
            }, ARRAY_FILTER_USE_BOTH);
            if (count($directPermissions) > 0) {
                $permissions = array_column($directPermissions, 'id');
                $user->givePermissionTo([$permissions]);
                $message .= "Les permissions ont été accordées directement à l'utilisateur $user->name";
            }
        }

        return response()->json(
            [
                'message' => $message,
                'directs' => $directPermissions,
                'requete' => $request->all(),
            ]
        );
    }

    public function autoriserByRole(Request $request): JsonResponse
    {
        $this->validate($request, ['role' => 'required']);
        $user = User::with('roles')->findOrFail($request->id);
        $newRole = Role::findOrFail($request->role);
        if (count($user->roles->all()) > 0) {
            $user->removeRole($user->roles->first());
        }
        $user->assignRole($newRole);
        $message = "Le role $newRole->name, a été attribué avec succès à l'utilisateur $user->name";
        return response()->json(['message' => $message]);
    }

    public function trash(int $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->delete();
        $message = "L'utilisateur $user->name a été supprimé avec succès.";
        return response()->json(['message' => $message]);
    }

    public function restore(int $id): JsonResponse
    {
        $user = User::withTrashed()->find($id);
        $user->restore();
        $message = "L'utilisateur $user->name a été restauré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function uncommercials()
    {
        $users = User::doesntHave('commercial')->get();
        return response()->json(['users' => $users]);
    }

    public function uncashiers()
    {
        $users = User::doesntHave('caissier')->get();
        return response()->json(['users' => $users]);
    }
}
