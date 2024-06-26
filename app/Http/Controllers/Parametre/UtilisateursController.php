<?php

namespace App\Http\Controllers\Parametre;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UtilisateursController extends Controller
{
    public function all(): JsonResponse
    {
        $response = Gate::inspect('viewAny', User::class);
        $query = User::with('avatar');
        $users = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['users' => UserResource::collection($users)]);
    }

    public function trashed(): JsonResponse
    {
        $response = Gate::inspect('viewAny', User::class);
        $query = User::onlyTrashed();
        $users = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['users' => UserResource::collection($users)]);
    }

    public function show(int $id): JsonResponse
    {
        $user = User::with(['roles', 'permissions', 'sites', 'avatar'])->withTrashed()->findOrFail($id);
        $this->authorize('view', $user);
        $permissions = $user->getAllPermissions();
        return response()->json(['user' => UserResource::make($user), 'permissions' => $permissions]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', User::class);
        $request->validate(User::RULES);
        $user = new User($request->all());
        $user->password = Hash::make($request->password);
        $user->disconnect();
        $user->save();
        $user->sites()->sync(explode(',', $request->sites));
        $role = Role::find($request->role_id);
        $user->assignRole($role);
        $user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        return response()->json(['message' => "L'utilisateur $request->name a été crée avec succès."]);
    }

    public function profile(Request $request): JsonResponse
    {
        $user = User::findOrFail($request->id);
        $this->authorize('update', $user);
        $validator = Validator::make($request->all(), User::infosRules($request->id));
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        } else {
            $user->name = $request->name;
            $user->adresse = $request->adresse;
            $user->description = $request->description;
            $user->save();
            if (!empty($request->sites)) {
                $user->sites()->sync($request->sites);
            }
            if ($request->hasFile('image')) {
                $user->addMediaFromRequest('image')->toMediaCollection('avatar');
            }
            return response()->json(['message' => "Utilisateur a été modifié avec succes."]);
        }
    }

    public function notifications(): JsonResponse
    {
        return response()->json(['message' => ""]);
    }

    public function security(Request $request): JsonResponse
    {
        $user = User::findOrFail($request->id);
        $this->authorize('update', $user);
        $validator = Validator::make($request->all(), User::SECURITY_RULES);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        } else {
            if (!Hash::check($request->oldPassword, $user->password)) {
                return response()->json(['message' => 'Ancien mot de passe incorrecte.'], 400);
            } else {
                if (!empty($request->password)) {
                    $user->password = Hash::make($request->password);
                }
                $user->save();
                return response()->json(['message' => 'Utilisateur a été modifié avec succes.']);
            }
        }
    }

    public function trash(int $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $this->authorize('delete', $user);
        $user->delete();
        return response()->json(['message' => "L'utilisateur $user->name a été supprimé avec succès."]);
    }

    public function restore(int $id): JsonResponse
    {
        $user = User::withTrashed()->find($id);
        $this->authorize('restore', $user);
        $user->restore();
        return response()->json(['message' => "L'utilisateur $user->name a été restauré avec succès."]);
    }

    public function uncommercials(): JsonResponse
    {
        $response = Gate::inspect('viewAny', User::class);
        $query = User::doesntHave('commercial');
        $users = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['users' => $users]);
    }

    public function uncashiers(): JsonResponse
    {
        $response = Gate::inspect('viewAny', User::class);
        $query = User::doesntHave('caissier');
        $users = $response->allowed() ? $query->get() : $query->owner()->get();

        return response()->json(['users' => $users]);
    }

    public function attribuer(Request $request): JsonResponse
    {
        $user = User::find($request->user);
        $this->authorize('attribuate', $user);
        $request->validate(['role' => 'required|not_in:0']);
        $role = Role::find($request->role);
        $user->assignRole($role);
        return response()->json(['message' => "Le rôle $role->name a été attribué à l'utilisateur $user->name"]);
    }
}
