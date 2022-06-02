<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Interfaces\StandardControllerInterface;
use App\Models\Architecture\Equipement;
use Illuminate\Http\Request;

class EquipementsController extends Controller implements StandardControllerInterface
{
    public function all()
    {
        $equipements = Equipement::with('type', 'emplacement')->get();
        return response()->json(['equipements' => $equipements]);
    }

    public function store(Request $request)
    {
        $request->validate(Equipement::RULES);
        $equipement = new Equipement($request->all());
        //  $equipement->genererCode()
        $equipement->save();
        $message = "L'équipement $equipement->nom a été enregistré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function update(int $id, Request $request)
    {
        $request->validate(Equipement::RULES);
        $equipement = Equipement::find($id);
        $equipement->update($request->all());
        $message = "L'équipement $equipement->nom a été modifié avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trash(int $id)
    {
        $equipement = Equipement::find($id);
        $equipement->delete();
        $message = "L'équipement $equipement->nom a été supprimé avec succès.";
        return response()->json(['message' => $message]);

    }

    public function trashed()
    {
        $equipements = Equipement::with('type', 'emplacement')->onlyTrashed()->get();
        return response()->json(['equipements' => $equipements]);

    }

    public function restore(int $id)
    {
        $equipement = Equipement::withTrashed()->find($id);
        $equipement->restore();
        $message = "L'équipement $equipement->nom a été restauré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function show(int $id)
    {
        $equipement = Equipement::withTrashed()->find($id);
        return response()->json(['equipement' => $equipement]);
    }
}
