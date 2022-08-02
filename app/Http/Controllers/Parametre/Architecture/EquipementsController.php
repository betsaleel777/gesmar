<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Interfaces\StandardControllerInterface;
use App\Models\Architecture\Abonnement;
use App\Models\Architecture\Equipement;
use App\Models\Architecture\Site;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EquipementsController extends Controller implements StandardControllerInterface
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

        return ['code' => 'EQU'.str_pad($rang, 7, '0', STR_PAD_LEFT), 'rang' => $rang];
    }

    public function all(): JsonResponse
    {
        $equipements = Equipement::with('type', 'site')->get();

        return response()->json(['equipements' => $equipements]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(Equipement::RULES);
        $equipement = new Equipement($request->all());
        ['code' => $code, 'rang' => $rang] = self::codeGenerate($request->site_id);
        $equipement->code = $code;
        $equipement->nom = 'EQUIPEMENT '.$rang;
        $equipement->free();
        $equipement->save();
        $message = "L'équipement $equipement->nom a été enregistré avec succès.";

        return response()->json(['message' => $message]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $request->validate(Equipement::RULES);
        $equipement = Equipement::findOrFail($id);
        $equipement->update($request->all());
        $message = "L'équipement $equipement->nom a été modifié avec succès.";

        return response()->json(['message' => $message]);
    }

    public function trash(int $id): JsonResponse
    {
        $equipement = Equipement::findOrFail($id);
        $equipement->delete();
        $message = "L'équipement $equipement->nom a été supprimé avec succès.";

        return response()->json(['message' => $message]);
    }

    public function trashed(): JsonResponse
    {
        $equipements = Equipement::with('type')->onlyTrashed()->get();

        return response()->json(['equipements' => $equipements]);
    }

    public function restore(int $id): JsonResponse
    {
        $equipement = Equipement::withTrashed()->find($id);
        $equipement->restore();
        $message = "L'équipement $equipement->nom a été restauré avec succès.";

        return response()->json(['message' => $message]);
    }

    public function show(int $id): JsonResponse
    {
        $equipement = Equipement::with('type')->withTrashed()->find($id);

        return response()->json(['equipement' => $equipement]);
    }

    public function getFromTypesAndBail(Request $request): JsonResponse
    {
        $equipements = Equipement::whereIn('type_equipement_id', $request->types)->whereNotNull('date_libre')->get();
        $abonnements = Abonnement::where('emplacement_id', $request->emplacement_id)->enCours()->get();
        $idsEquipementsSuscribed = $abonnements->map(function ($abonnement) {
            return $abonnement->equipement_id;
        });
        if (! empty($abonnements->all()) and ! empty($equipements->all())) {
            foreach ($equipements as $equipement) {
                in_array($equipement->id, $idsEquipementsSuscribed->all())
                ? $equipement->setAttribute('linked', true) : $equipement->setAttribute('linked', false);
            }
        }

        return response()->json(['equipements' => $equipements]);
    }
}
