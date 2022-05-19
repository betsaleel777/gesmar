<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Models\Architecture\Emplacement;
use App\Models\Architecture\Zone;
use Illuminate\Http\Request;

class EmplacementsController extends Controller
{
    public function all()
    {
        $emplacements = Emplacement::with('type', 'zone')->get();
        return response()->json(['emplacements' => $emplacements]);
    }

    public function show(int $id)
    {
        $emplacement = Emplacement::with('type', 'zone')->find($id);
        return response()->json(['emplacement' => $emplacement]);
    }

    public function store(Request $request)
    {
        $request->validate(Emplacement::RULES);
        $emplacement = new Emplacement($request->all());
        $emplacement->code = (int) Zone::find($request->zone_id)->zones->count() + 1;
        $emplacement->save();
        $message = "L'emplacement $request->nom a été crée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function update(int $id, Request $request)
    {

    }

    public function trashed()
    {

    }

    public function trash(int $id)
    {

    }

}
