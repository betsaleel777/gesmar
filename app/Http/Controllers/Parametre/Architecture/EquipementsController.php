<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Events\EquipementRegistred;
use App\Http\Controllers\Controller;
use App\Http\Resources\Abonnement\EquipementListResource;
use App\Models\Architecture\Equipement;
use App\Models\Architecture\Site;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EquipementsController extends Controller
{
    /**
     * Undocumented function
     *
     * @param  int  $site
     * @return array<string, string>
     */
    private static function codeGenerate(int $site): array
    {
        $rang = (string) (Site::findOrFail($site)->equipements->count() + 1);
        return ['code' => 'EQU' . str_pad($rang, 7, '0', STR_PAD_LEFT), 'rang' => $rang];
    }

    public function all(): JsonResponse
    {
        $equipements = Equipement::with('site')->get();
        return response()->json(['equipements' => EquipementListResource::collection($equipements)]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Equipement::class);
        $request->validate(Equipement::RULES);
        $equipement = new Equipement($request->all());
        ['code' => $code, 'rang' => $rang] = self::codeGenerate($request->site_id);
        $equipement->code = $code;
        $equipement->nom = 'EQUIPEMENT ' . $rang;
        $equipement->save();
        is_null($equipement->emplacement_id) ?: $equipement->lier();
        EquipementRegistred::dispatchIf(!is_null($equipement->emplacement_id), $equipement);
        $message = "L'équipement $equipement->nom a été enregistré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $equipement = Equipement::findOrFail($id);
        $this->authorize('update', $equipement);
        $request->validate(Equipement::RULES);
        $ancienEmplacement = (int) $equipement->emplacement_id;
        $equipement->update($request->all());
        $eventCondition = $ancienEmplacement !== (int)$equipement->emplacement_id;
        EquipementRegistred::dispatchIf($eventCondition, $equipement, $ancienEmplacement);
        $message = "L'équipement $equipement->nom a été modifié avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trash(int $id): JsonResponse
    {
        $equipement = Equipement::findOrFail($id);
        $this->authorize('delete', $equipement);
        $equipement->delete();
        $message = "L'équipement $equipement->nom a été supprimé avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trashed(): JsonResponse
    {
        $equipements = Equipement::onlyTrashed()->get();

        return response()->json(['equipements' => $equipements]);
    }

    public function restore(int $id): JsonResponse
    {
        $equipement = Equipement::withTrashed()->find($id);
        $this->authorize('restore', $equipement);
        $equipement->restore();
        $message = "L'équipement $equipement->nom a été restauré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function show(int $id): JsonResponse
    {
        $equipement = Equipement::with('emplacement')->withTrashed()->find($id);
        $this->authorize('view', $equipement);
        return response()->json(['equipement' => $equipement]);
    }

    public function getUnlinkedsubscribed(): JsonResponse
    {
        $equipements = Equipement::unlinked()->unsubscribed()->get();
        return response()->json(['equipements' => $equipements]);
    }

    /**
     * Récupère les équipements non abonnés et non liés selon le marché et conserve l'équipement déjà lié de l'emplacement
     *
     */
    public function getGearsForContratView(int $id, int $emplacement, int $site): JsonResponse
    {

        $equipementLinked = Equipement::where('type_equipement_id', $id)->where('emplacement_id', $emplacement)->first();
        $equipements = Equipement::where('site_id', $site)->where('type_equipement_id', $id)
            ->unlinked()->unsubscribed()->get();
        empty($equipementLinked) ?: $equipements->push($equipementLinked);
        return response()->json(['equipements' => $equipements]);
    }
}
