<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Events\AbonnementResilied;
use App\Http\Controllers\Controller;
use App\Models\Architecture\Abonnement;
use App\Models\Architecture\Equipement;
use App\Models\Architecture\Site;
use App\Models\Exploitation\Contrat;
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
        foreach ($request->equipements as $equipement) {
            $abonnement = new Abonnement($request->all());
            $abonnement->code = self::codeGenerate($request->site_id);
            $abonnement->index_depart = $equipement['index_depart'];
            $abonnement->index_autre = $equipement['index_autre'];
            $abonnement->equipement_id = $equipement['id'];
            $abonnement->save();
            $abonnement->process();
        }
        $message = "L'abonnement $abonnement->code a été crée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function insert(Request $request): JsonResponse
    {
        $request->validate(['equipement_id' => 'required', 'index_depart' => 'required', 'index_autre' => 'required']);
        $equipement = Equipement::with('type')->findOrFail($request->equipement_id);
        $abonnement = new Abonnement($request->all());
        $abonnement->site_id = $equipement->site_id;
        $abonnement->code = self::codeGenerate($equipement->site_id);
        $abonnement->save();
        $request->index_depart === (int)$request->index_autre ? $abonnement->process() : $abonnement->error();
        Contrat::find($request->contrat_id)->equipements()->updateExistingPivot($equipement->type, ['abonnable' => false]);
        $message = "L'abonnement $abonnement->code a été crée avec succès.";
        return response()->json(['message' => $message, 'abonnement' => $abonnement]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $request->validate(Abonnement::RULES);
        $abonnement = Abonnement::findOrFail($id);
        $abonnement->update($request->all());
        $message = "L'abonnement $request->code a été modifié avec succès.";
        return response()->json(['message' => $message]);
    }

    public function show(int $id): JsonResponse
    {
        $abonnement = Abonnement::with('emplacement', 'equipement.type')->find($id);
        return response()->json(['abonnement' => $abonnement]);
    }

    public function lastIndex(int $id): JsonResponse
    {
        $equipement = null;
        $abonnement = Abonnement::with('emplacement', 'equipement.type')->orderBy('id', 'DESC')->firstWhere('equipement_id', $id);
        if (empty($abonnement->index_depart)) {
            $equipement = Equipement::findOrFail($id);
        }
        return response()->json(['index' => $abonnement->index_fin ?? $abonnement->index_depart ?? $equipement?->index]);
    }

    public function finish(int $id, Request $request): JsonResponse
    {
        $request->validate(Abonnement::FINISH_RULES);
        $abonnement = Abonnement::findOrFail($id);
        $abonnement->index_fin = $request->indexFin;
        $abonnement->save();
        $abonnement->stop();
        AbonnementResilied::dispatch($abonnement);
        $message = "L'abonnement $request->code a été résilié avec succès.";
        return response()->json(['message' => $message]);
    }
}