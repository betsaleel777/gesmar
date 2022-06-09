<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Interfaces\StandardControllerInterface;
use App\Models\Architecture\Equipement;
use App\Models\Architecture\Site;
use Illuminate\Http\Request;

class EquipementsController extends Controller implements StandardControllerInterface
{
    private static function codeGenerate(int $site)
    {
        $rang = Site::find($site)->equipements->count() + 1;
        return ['code' => 'EQU' . str_pad($rang, 7, '0', STR_PAD_LEFT), 'rang' => $rang];
    }

    public function all()
    {
        $equipements = Equipement::with('type', 'site')->get();
        return response()->json(['equipements' => $equipements]);
    }

    public function store(Request $request)
    {
        $request->validate(Equipement::RULES);
        $equipement = new Equipement($request->all());
        ['code' => $code, 'rang' => $rang] = self::codeGenerate($request->site_id);
        $equipement->code = $code;
        $equipement->nom = 'EQUIPEMENT ' . $rang;
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
        $equipements = Equipement::with('type')->onlyTrashed()->get();
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
        $equipement = Equipement::with('type')->withTrashed()->find($id);
        return response()->json(['equipement' => $equipement]);
    }
}
