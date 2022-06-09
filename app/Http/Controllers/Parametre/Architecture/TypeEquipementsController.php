<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Interfaces\StandardControllerInterface;
use App\Models\Architecture\TypeEquipement;
use Illuminate\Http\Request;

class TypeEquipementsController extends Controller implements StandardControllerInterface
{
    public function all()
    {
        $types = TypeEquipement::with('site')->get();
        return response()->json(['types' => $types]);
    }

    public function store(Request $request)
    {
        $request->validate(TypeEquipement::RULES);
        $type = new TypeEquipement($request->all());
        $type->save();
        $message = "Le type d'équipement $request->nom a été enrgistré avec succès.";
        return response()->json(['message' => $message, 'id' => $type->id]);
    }

    public function update(int $id, Request $request)
    {
        $request->validate(TypeEquipement::RULES);
        $type = TypeEquipement::find($id);
        $type->nom = $request->nom;
        $type->site_id = $request->site_id;
        $type->frais_penalite = $request->frais_penalite;
        $type->save();
        $message = "Type d'équipement a été modifié avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trash(int $id)
    {
        $type = TypeEquipement::find($id);
        $type->delete();
        $message = "Le type d'équipement: $type->nom a été supprimé avec succès.";
        return response()->json(['message' => $message]);
    }

    public function restore(int $id)
    {
        $type = TypeEquipement::withTrashed()->find($id);
        $type->restore();
        $message = "Le type d'équipement $type->nom a été restauré avec succès.";
        return response()->json(['message' => $message]);

    }

    public function trashed()
    {
        $types = TypeEquipement::with('site')->onlyTrashed()->get();
        return response()->json(['types' => $types]);
    }

    public function show(int $id)
    {
        $type = TypeEquipement::with('site')->withTrashed()->find($id);
        return response()->json(['type' => $type]);
    }
}
