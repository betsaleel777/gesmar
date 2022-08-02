<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Models\Architecture\Abonnement;
use App\Models\Architecture\Equipement;
use App\Models\Architecture\Site;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AbonnementsController extends Controller
{
    private static function codeGenerate(int $site): string
    {
        $site = Site::with('abonnements')->findOrFail($site);
        $rang = $site->abonnements->count() + 1;
        $place = str_pad((string) $rang, 6, '0', STR_PAD_LEFT);

        return 'AB' . str_pad((string) $site->id, 2, '0', STR_PAD_LEFT) . $place;
    }

    public function all(): JsonResponse
    {
        $abonnements = Abonnement::with('emplacement', 'equipement.type')->get();

        return response()->json(['abonnements' => $abonnements]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(Abonnement::RULES);
        $abonnement = new Abonnement($request->all());
        $abonnement->code = self::codeGenerate($request->site_id);
        $abonnement->save();
        $equipement = Equipement::findOrFail($request->equipement_id);
        $equipement->busy();
        $equipement->save();
        $message = "L'abonnement $request->code a été crée avec succès.";

        return response()->json(['message' => $message]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $request->validate(Abonnement::RULES);
        $abonnement = Abonnement::findOrFail($id);
        $abonnement->update($request->all());
        $message = "L'abonnement $request->code a été modifié avec succès.";

        return response()->json(['message' => $message]);
    }

    // public function trash(int $id)
    // {
    //     $abonnement = Abonnement::find($id);
    //     $equipement = Equipement::find($abonnement->equipement_id);
    //     $equipement->free();
    //     $equipement->save();
    //     $abonnement->delete();
    //     $message = "L'abonnement $abonnement->code a été supprimé avec succès.";
    //     return response()->json(['message' => $message]);
    // }

    // public function restore(int $id)
    // {
    //     $abonnement = Abonnement::withTrashed()->find($id);
    //     $abonnement->restore();
    //     $message = "L'abonnement $abonnement->code a été restauré avec succès.";
    //     return response()->json(['message' => $message]);
    // }

    // public function trashed()
    // {
    //     $abonnements = Abonnement::with('emplacement', 'equipement.type')->onlyTrashed()->get();
    //     return response()->json(['abonnements' => $abonnements]);
    // }

    public function show(int $id): JsonResponse
    {
        $abonnement = Abonnement::with('emplacement', 'equipement.type')->find($id);

        return response()->json(['abonnement' => $abonnement]);
    }

    public function lastIndex(int $id): JsonResponse
    {
        $equipement = null;
        $abonnement = Abonnement::with('emplacement', 'equipement.type')->where('equipement_id', $id)->orderBy('id', 'DESC')->first();
        if (empty($abonnement->index_depart)) {
            $equipement = Equipement::findOrFail($id);
        }

        return response()->json(['index' => $abonnement->index_fin ?? $abonnement->index_depart ?? $equipement?->index]);
    }

    public function finish(int $id, Request $request): JsonResponse
    {
        $request->validate(Abonnement::FINISH_RULES);
        $abonnement = Abonnement::findOrFail($id);
        $abonnement->index_fin = $request->index_fin;
        $abonnement->stop();
        $equipement = Equipement::findOrFail($abonnement->equipement_id);
        $equipement->free();
        $equipement->save();
        $abonnement->save();
        $message = "L'abonnement $request->code a été résilié avec succès.";

        return response()->json(['message' => $message]);
    }
}
