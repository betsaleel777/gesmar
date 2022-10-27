<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Interfaces\StandardControllerInterface;
use App\Models\Architecture\Emplacement;
use App\Models\Architecture\Zone;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmplacementsController extends Controller implements StandardControllerInterface
{
    /**
     * Génerer le code de l'emplacement
     *
     * @param  int  $id
     * @return array<string, string>
     */
    private static function codeGenerate(int $id): array
    {
        $zone = Zone::with('emplacements')->findOrFail($id);
        $rang = (string) ($zone->emplacements->count() + 1);
        $place = str_pad($rang, 3, '0', STR_PAD_LEFT);
        $code = $zone->code . $place;
        return ['code' => $code, 'rang' => $rang];
    }

    public function all(): JsonResponse
    {
        $emplacements = Emplacement::with('zone.niveau.pavillon.site')->get();
        return response()->json(['emplacements' => $emplacements]);
    }

    public function allAuto()
    {
        $emplacements = Emplacement::with('zone.niveau.pavillon.site')->withoutSchedule()->get();
        return response()->json(['emplacements' => $emplacements]);
    }

    public function equipables(): JsonResponse
    {
        $emplacements = DB::table('emplacements')->select(['emplacements.*', 'pavillons.site_id'])
            ->join('zones', 'zones.id', '=', 'emplacements.zone_id')
            ->join('niveaux', 'zones.niveau_id', '=', 'niveaux.id')->join('pavillons', 'niveaux.pavillon_id', '=', 'pavillons.id')
            ->join('type_emplacements', 'type_emplacements.id', '=', 'emplacements.type_emplacement_id')
            ->where('type_emplacements.equipable', true)->get();
        return response()->json(['emplacements' => $emplacements]);
    }

    public function show(int $id): JsonResponse
    {
        $emplacement = Emplacement::with(['type', 'zone.niveau.pavillon.site'])->findOrFail($id);
        return response()->json(['emplacement' => $emplacement]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(Emplacement::RULES);
        $emplacement = new Emplacement($request->all());
        ['code' => $code] = self::codeGenerate($request->zone_id);
        $emplacement->code = $code;
        $emplacement->save();
        $emplacement->liberer();
        $emplacement->delier();
        $message = "L'emplacement $request->nom a été crée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $request->validate(Emplacement::RULES);
        $emplacement = Emplacement::findOrFail($id);
        $emplacement->update($request->all());
        $message = "L'emplacement $request->nom a été modifié avec succès.";
        return response()->json(['message' => $message]);
    }

    public function restore(int $id): JsonResponse
    {
        $emplacement = Emplacement::withTrashed()->find($id);
        $emplacement->restore();
        $message = "L'emplacement $emplacement->nom a été restauré avec succès.";
        return response()->json(['message' => $message]);
    }

    /**
     * Liste des emplacements archivés
     *
     * @return JsonResponse
     */
    public function trashed(): JsonResponse
    {
        $emplacements = Emplacement::with('zone')->onlyTrashed()->get();
        return response()->json(['emplacements' => $emplacements]);
    }

    /**
     * Archivage d'emplacement
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function trash(int $id): JsonResponse
    {
        $emplacement = Emplacement::findOrFail($id);
        $emplacement->delete();
        $message = "L'emplacement $emplacement->nom a été supprimé avec succès.";
        return response()->json(['message' => $message]);
    }

    /**
     * Insertion massive d'emplacement de même attributs
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function push(Request $request): JsonResponse
    {
        $request->validate(Emplacement::PUSH_RULES);
        $compteur = $request->nombre;
        while ($compteur > 0) {
            $emplacement = new Emplacement($request->all());
            ['code' => $code, 'rang' => $rang] = self::codeGenerate($request->zone_id);
            $emplacement->code = $code;
            $emplacement->nom = 'EMPLACEMENT ' . $rang;
            $emplacement->save();
            $compteur--;
        }
        $message = "$request->nombre emplacements ont été crées avec succès.";
        return response()->json(['message' => $message]);
    }

    /**
     * Récupère tout les emplacements dans un marché ou site spécifié
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function getByMarche(int $id): JsonResponse
    {
        $emplacements = Emplacement::whereHas('site', fn(Builder $query) => $query->where('sites.id', $id))->get();
        return response()->json(['emplacements' => $emplacements]);
    }

    /**
     * Récupère les emplacements selon l'id d'un marché et l'existence d'un contrat non résilié en chargeant les équipements liés et leurs types
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function getByMarcheWithGearsAndContracts(int $id): JsonResponse
    {
        $emplacements = Emplacement::with('equipements')->whereHas('contrats', fn(Builder $query) => $query->notAborted())
            ->whereHas('site', fn($query) => $query->where('sites.id', $id))->get();
        return response()->json(['emplacements' => $emplacements]);
    }

    /**
     * Récupère les emplacements lié à aucun équipement selon le site (marché)
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function getUnlinkedByMarche(int $id): JsonResponse
    {
        $emplacements = Emplacement::isUnlinked()->whereHas('site', fn(Builder $query) => $query->where('sites.id', $id))->get();
        return response()->json(['emplacements' => $emplacements]);
    }

    /**
     * Récupère les emplacements libre selon le site
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function getFreeByMarche(int $id): JsonResponse
    {
        $emplacements = Emplacement::isFree()->whereHas('site', fn(Builder $query) => $query->where('sites.id', $id))->get();
        return response()->json(['emplacements' => $emplacements]);
    }

    /**
     * Récupère les emplacements occupés selon le site
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function getBusyByMarche(int $id): JsonResponse
    {
        $emplacements = Emplacement::isBusy()->whereHas('site', fn($query) => $query->where('sites.id', $id))->get();
        return response()->json(['emplacements' => $emplacements]);
    }

    public function getRentalbyMonth(string $date): JsonResponse
    {
        $emplacements = Emplacement::with(['contratActuel.factureInitiale', 'contratActuel.personne'])
            ->whereHas(
                'contratActuel.factureInitiale',
                function (Builder $query) use ($date) {
                    $query->where('factures.code', 'LIKE', 'FAL%')->whereMonth('factures.periode', '!=', Carbon::parse($date)->format('m'))
                        ->whereYear('factures.periode', '!=', Carbon::parse($date)->format('Y'))->orWhereNull('factures.periode');
                }
            )->whereHas('contratActuel.personne', fn(Builder $query) => $query->isClient())
            ->whereHas('contratActuel', fn(Builder $query) => $query->where('auto_valid', false))->get();
        return response()->json(['emplacements' => $emplacements]);
    }
}
