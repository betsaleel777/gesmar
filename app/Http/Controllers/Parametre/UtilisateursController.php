<?php

namespace App\Http\Controllers\Parametre;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UtilisateursController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::get();
        $titre = 'Utilisateurs';
        return view('parametre.utilisateur.index', compact('titre', 'users'));
    }

    public function add()
    {
        $titre = 'Créer utilisateur';
        return view('parametre.utilisateur.add', compact('titre'));
    }

    public function insert(Request $request)
    {
        $request->validate(User::RULES);
        $user = new User($request->all());
        $user->password = Hash::make($request->password);
        $path = substr($request->file('avatar')->store('public/user-' . $request->id), 7);
        $user->avatar = $path;
        $user->deconnecter();
        $user->save();
        $message = "L'utilisateur $request->name a été crée avec succès.";
        return redirect()->route('admin.user.index')->with('success', $message);
    }

    public function informations(Request $request)
    {
        $validator = Validator::make($request->all(), User::infosRules($request->id));
        $user = User::find($request->id);
        if ($validator->fails()) {
            return redirect()->route('admin.user.setting', ['id' => $user->id, 'panel' => $request->panel])->withErrors($validator)->withInput();
        } else {
            $user->name = $request->name;
            $user->adresse = $request->adresse;
            $user->description = $request->description;
            if ($request->hasFile('avatar')) {
                !empty($user->avatar) ? Storage::delete('storage/' . $user->avatar) : null;
                $path = substr($request->file('avatar')->store('public/user-' . $request->id), 7);
                $user->avatar = $path;
            }
            $user->save();
            $message = "Utilisateur a été modifié avec succes.";
            return redirect()->route('admin.user.setting', ['id' => $user->id, 'panel' => $request->panel])->with('success', $message);
        }
    }

    public function notifications(Request $request)
    {

    }

    public function securite(Request $request)
    {
        $validator = Validator::make($request->all(), User::SECURITE_RULE);
        $user = User::find($request->id);
        if ($validator->fails()) {
            return redirect()->route('admin.user.setting', ['id' => $user->id, 'panel' => $request->panel])->withErrors($validator)->withInput();
        } else {
            if (!Hash::check($request->oldPassword, $user->password)) {
                $message = "Ancien mot de passe incorrecte.";
                return redirect()->route('admin.user.setting', ['id' => $user->id, 'panel' => $request->panel])->with('error', $message);
            } else {
                if (!empty($request->password)) {
                    $user->password = Hash::make($request->password);
                }
                $user->save();
                $message = "Utilisateur a été modifié avec succes.";
                return redirect()->route('admin.user.setting', ['id' => $user->id, 'panel' => $request->panel])->with('success', $message);
            }
        }

    }

    public function permissions(Request $request)
    {

    }

    public function show(int $id)
    {
        $user = User::find($id);
        $titre = $user->name;
        return view('parametre.utilisateur.show', compact('titre', 'user'));
    }

    public function setting(int $id, string $panel)
    {
        $user = User::find($id);
        $titre = $user->name;
        $active = $panel;
        return view('parametre.utilisateur.setting', compact('titre', 'user', 'active'));
    }

    public function archive()
    {
        $users = User::onlyTrashed()->get();
        $titre = 'Utilisateurs Archivés';
        return view('parametre.utilisateur.archive', compact('titre', 'users'));
    }

    public function trash(int $id)
    {
        $user = User::find($id);
        $user->delete();
        $message = "L'utilisateur $user->name a été supprimé avec succès.";
        return redirect()->back()->with('success', $message);
    }

    public function restore(int $id)
    {
        $user = User::withTrashed()->find($id);
        $user->restore();
        $message = "L'utilisateur $user->name a été restauré avec succès.";
        return redirect()->back()->with('success', $message);
    }
}
