<?php

namespace App\Http\Controllers\Parametre;

use App\Http\Controllers\Controller;
use App\Http\Resources\SocieteCollection;
use App\Http\Resources\SocieteResource;
use App\Models\Societe;
use Illuminate\Http\Request;

class SocieteController extends Controller
{
    public function all(): SocieteCollection
    {
        return new SocieteCollection(Societe::all());
    }

    public function store(Request $request)
    {
        $request->validate(Societe::RULES);
        $societe = new Societe($request->all());
        $path = substr($request->file('logo')->store('public/societe-' . $societe->id), 7);
        $societe->logo = $path;
        $societe->save();
        return response()->json(['message' => "La société $request->nom a été crée avec succès."]);
    }

    public function update(int $id, Request $request)
    {
        $request->validate(Societe::editRules($id));
        $societe = Societe::findOrFail($id);
        if ($request->hasFile('image') and !empty($societe->logo)) {
            unlink(public_path() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . $societe->logo);
            $path = substr($request->file('image')->store('public/societe-' . $id), 7);
            $societe->logo = $path;
        } else if ($request->hasFile('image') and empty($societe->logo)) {
            $path = substr($request->file('image')->store('public/societe-' . $id), 7);
            $societe->logo = $path;
        }
        $societe->nom = $request->nom;
        $societe->sigle = $request->sigle;
        $societe->siege = $request->siege;
        $societe->capital = $request->capital;
        $societe->save();
        return response()->json(['message' => "La société a été modifiée avec succès."]);
    }

    public function show(int $id): SocieteResource
    {
        return new SocieteResource(Societe::find($id));
    }
}
