<?php

namespace App\Http\Controllers\Parametre;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
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
        return response()->json(['users' => UserResource::collection($users)]);
    }

    public function trashed(): JsonResponse
    {
        $users = User::onlyTrashed()->get();
        return response()->json(['users' => UserResource::collection($users)]);
    }

    public function show(int $id): JsonResponse
    {
        $user = User::with(['roles', 'permissions', 'sites'])->withTrashed()->findOrFail($id);
        $permissions = $user->getAllPermissions();
        return response()->json(['user' => UserResource::make($user), 'permissions' => $permissions]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(User::RULES);
        $user = new User($request->all());
        $user->password = Hash::make($request->password);
        $user->disconnect();
        $user->save();
        $user->sites()->sync($request->sites);
        $role = Role::find($request->role_id);
        $user->assignRole($role);
        $user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
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
            $user->save();
            $user->sites()->sync($request->sites);
            if ($request->hasFile('image')) {
                $user->addMediaFromRequest('image')->toMediaCollection('avatar');
            }
            $message = "Utilisateur a été modifié avec succes.";
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

    public function uncommercials(): JsonResponse
    {
        $users = User::doesntHave('commercial')->get();
        return response()->json(['users' => $users]);
    }

    public function uncashiers(): JsonResponse
    {
        $users = User::doesntHave('caissier')->get();
        return response()->json(['users' => $users]);
    }

    public function attribuer(Request $request): JsonResponse
    {
        $request->validate(['role' => 'required|not_in:0']);
        $user = User::find($request->user);
        $role = Role::find($request->role);
        $user->assignRole($role);
        return response()->json(['message' => "Le rôle $role->name a été attribué à l'utilisateur $user->name"]);
    }
}
