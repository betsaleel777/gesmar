<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Interfaces\StandardControllerInterface;
use App\Models\Architecture\Emplacement;
use App\Models\Architecture\Zone;
use Illuminate\Http\Request;

class EmplacementsController extends Controller implements StandardControllerInterface
{
    private static function codeGenerate(int $id)
    {
        $zone = Zone::with('niveau.pavillon', 'emplacements')->find($id);
        $rang = (int) $zone->emplacements->count() + 1;
        $place = str_pad($rang, 3, '0', STR_PAD_LEFT);
        $code = $zone->niveau->pavillon->code . $zone->niveau->code . $zone->code . $place;
        return ['code' => $code, 'rang' => $rang];
    }

    public function all()
    {
        $emplacements = Emplacement::with('type', 'zone.niveau.pavillon.site')->get();
        return response()->json(['emplacements' => $emplacements]);
    }

    public function show(int $id)
    {
        $emplacement = Emplacement::with('type', 'zone.niveau.pavillon.site')->find($id);
        return response()->json(['emplacement' => $emplacement]);
    }

    public function store(Request $request)
    {
        $request->validate(Emplacement::RULES);
        $emplacement = new Emplacement($request->all());
        ['code' => $code] = self::codeGenerate($request->zone_id);
        $emplacement->code = $code;
        $emplacement->save();
        $message = "L'emplacement $request->nom a été crée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function update(int $id, Request $request)
    {
        $request->validate(Emplacement::RULES);
        $emplacement = Emplacement::find($id);
        $emplacement->nom = $request->nom;
        $emplacement->superficie = $request->superficie;
        $emplacement->loyer = $request->loyer;
        $emplacement->pas_porte = $request->pas_porte;
        $emplacement->zone_id = $request->zone_id;
        $emplacement->type_emplacement_id = $request->type_emplacement_id;
        $emplacement->save();
        $message = "L'emplacement $request->nom a été modifié avec succès.";
        return response()->json(['message' => $message]);
    }

    public function restore(int $id)
    {
        $emplacement = Emplacement::withTrashed()->find($id);
        $emplacement->restore();
        $message = "L'emplacement $emplacement->nom a été restauré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trashed()
    {
        $emplacements = Emplacement::with('zone', 'type')->onlyTrashed()->get();
        return response()->json(['emplacements' => $emplacements]);
    }

    public function trash(int $id)
    {
        $emplacement = Emplacement::find($id);
        $emplacement->delete();
        $message = "L'emplacement $emplacement->nom a été supprimé avec succès.";
        return response()->json(['message' => $message]);
    }

    public function push(Request $request)
    {
        $request->validate(Emplacement::PUSH_RULES);
        $compteur = $request->nombre;
        while ($compteur > 0) {
            $emplacement = new Emplacement($request->all());
            $emplacement->code = self::codeGenerate($request->zone_id);
            ['code' => $code, 'rang' => $rang] = self::codeGenerate($request->zone_id);
            $emplacement->code = $code;
            $emplacement->nom = 'EMPLACEMENT ' . $rang;
            $emplacement->save();
            $compteur--;
        }
        $message = "$request->nombre emplacements ont été crées avec succès.";
        return response()->json(['message' => $message]);
    }
}
