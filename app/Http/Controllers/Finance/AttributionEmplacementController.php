<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Attribution;
use App\Models\Finance\Bordereau;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttributionEmplacementController extends Controller
{

    public function all(): JsonResponse
    {
        $attributions = Attribution::with(['commercial', 'emplacement', 'bordereau'])->orderBy('jour', 'desc')->get();
        return response()->json(['attributions' => $attributions]);
    }

    public function allWithBordereau(): JsonResponse
    {
        $attributions = Attribution::has('bordereau')->with(['commercial', 'emplacement', 'bordereau'])->orderBy('jour', 'desc')->get();
        return response()->json(['attributions' => $attributions]);
    }

    public function allAttribuated(string $date, int $commercial): JsonResponse
    {
        $emplacements = Attribution::where('jour', $date)->where('commercial_id', $commercial)->pluck('emplacement_id');
        return response()->json(['emplacements' => $emplacements]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(Attribution::RULES);
        $id_bordereau = $request->input('bordereau');
        if (empty($id_bordereau)) {
            $bordereau = new Bordereau(['date_attribution' => $request->jour, 'commercial_id' => $request->commercial]);
            $bordereau->codeGenerate();
            $bordereau->save();
            $bordereau->pasEncaisser();
            $id_bordereau = $bordereau->id;
        }
        foreach ($request->emplacements as $emplacement) {
            $attribution = new Attribution();
            $attribution->commercial_id = $request->commercial;
            $attribution->jour = $request->jour;
            $attribution->emplacement_id = $emplacement['id'];
            $attribution->bordereau_id = $id_bordereau;
            $attribution->save();
            $attribution->pasEncaisser();
        }
        $message = "Emplacement(s) attribué(s) avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trash(int $id): JsonResponse
    {
        $attribution = Attribution::with('emplacement')->findOrFail($id);
        $attribution->delete();
        $message = "Annulation de l'attribution de l'emplacement $attribution->emplacement->code pour la date du $attribution->jour;
         a été effectuée avec succès";
        return response()->json(['message' => $message]);
    }

    public function transfer(int $id, Request $request): JsonResponse
    {
        $request->validate(ATTRIBUTION::TRANSFERT_RULES);
        $attributions = Attribution::where('commercial_id', $request->commercial_id)->where('jour', $request->date)->get();
        $attributions->each(function (Attribution $attribution) use ($id) {
            if ($attribution->uncashed()) {
                $attribution->commercial_id = $id;
                $attribution->save();
            }
        });
        //TODO: vérifier si toutes les attributions du bordereau sont encaissées en vue de changer le statut du bordereau
        $message = "Le transfert des tâches a bien été effectué.";
        return response()->json(['message' => $message]);
    }
}
