<?php

namespace App\Http\Controllers\Parametre;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UtilisateursController extends Controller
{
    public function all()
    {
        $users = User::get();
        return response()->json(['users' => $users]);
    }

    public function trashed()
    {
        $users = User::onlyTrashed()->get();
        return response()->json(['users' => $users]);
    }

    public function show(int $id)
    {
        $user = User::withTrashed()->find($id);
        $permissions = $user->getAllPermissions()->all();
        $role = $user->getRoleNames();
        return response()->json(['user' => $user, 'permissions' => $permissions, 'role' => $role]);
    }

    public function store(Request $request)
    {
        $request->validate(User::RULES);
        $user = new User($request->all());
        $user->password = Hash::make($request->password);
        $path = substr($request->file('avatar')->store('public/user-' . $request->id), 7);
        $user->avatar = $path;
        $user->deconnecter();
        $user->save();
        $message = "L'utilisateur $request->name a été crée avec succès.";
        return response()->json(['message' => $message, 'request' => $request->all()]);
    }

    public function profile(Request $request)
    {
        $validator = Validator::make($request->all(), User::infosRules($request->id));
        $user = User::find($request->id);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        } else {
            $user->name = $request->name;
            $user->adresse = $request->adresse;
            $user->description = $request->description;
            if ($request->hasFile('image')) {
                unlink(public_path() . '/storage/' . $user->avatar);
                $path = substr($request->file('image')->store('public/user-' . $request->id), 7);
                $user->avatar = $path;
            }
            $user->save();
            $message = "Utilisateur a été modifié avec succes. \n
            Un rechargement de la page est nécessaire pour constater le rafraîchissement de l'image.";
            return response()->json(['message' => $message]);
        }
    }

    public function notifications(Request $request)
    {
        $message = "";
        return response()->json(['message' => $message]);
    }

    public function security(Request $request)
    {
        $validator = Validator::make($request->all(), User::SECURITY_RULES);
        $user = User::find($request->id);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        } else {
            if (!Hash::check($request->oldPassword, $user->password)) {
                $message = "Ancien mot de passe incorrecte.";
                return response()->json(['message' => $message], 400);
            } else {
                if (!empty($request->password)) {
                    $user->password = Hash::make($request->password);
                }
                $user->save();
                $message = "Utilisateur a été modifié avec succes.";
                return response()->json(['message' => $message]);
            }
        }

    }

    public function autoriser(Request $request)
    {

    }

    public function trash(int $id)
    {
        $user = User::find($id);
        $user->delete();
        $message = "L'utilisateur $user->name a été supprimé avec succès.";
        return response()->json(['message' => $message]);
    }

    public function restore(int $id)
    {
        $user = User::withTrashed()->find($id);
        $user->restore();
        $message = "L'utilisateur $user->name a été restauré avec succès.";
        return response()->json(['message' => $message]);
    }
}
