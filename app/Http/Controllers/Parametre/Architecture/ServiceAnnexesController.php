<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Interfaces\StandardControllerInterface;
use App\Models\Architecture\ServiceAnnexe;
use Illuminate\Http\Request;

class ServiceAnnexesController extends Controller implements StandardControllerInterface
{
    public function all()
    {
        $annexes = ServiceAnnexe::with('site')->get();
        return response()->json(['annexes' => $annexes]);
    }

    public function show(int $id)
    {
        $annexe = ServiceAnnexe::with('site')->find($id);
        return response()->json(['annexe' => $annexe]);
    }

    public function store(Request $request)
    {
        $request->validate(ServiceAnnexe::RULES);
        $annexe = new ServiceAnnexe($request->all());
        $annexe->save();
        $message = "Le service annexe $request->nom a été crée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function update(int $id, Request $request)
    {
        $request->validate(ServiceAnnexe::RULES);
        $annexe = ServiceAnnexe::find($id);
        $annexe->update($request->all());
        $annexe->save();
        $message = "Le service annexe $request->nom a été modifié avec succès.";
        return response()->json(['message' => $message]);
    }

    public function restore(int $id)
    {
        $annexe = ServiceAnnexe::withTrashed()->find($id);
        $annexe->restore();
        $message = "Le service annexe $annexe->nom a été restauré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trashed()
    {
        $annexes = ServiceAnnexe::with('type')->onlyTrashed()->get();
        return response()->json(['annexes' => $annexes]);
    }

    public function trash(int $id)
    {
        $annexe = ServiceAnnexe::find($id);
        $annexe->delete();
        $message = "Le service annexe $annexe->nom a été supprimé avec succès.";
        return response()->json(['message' => $message]);
    }
}
