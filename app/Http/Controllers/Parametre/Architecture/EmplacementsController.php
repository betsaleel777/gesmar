<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Enums\StatusAbonnement;
use App\Enums\StatusEmplacement;
use App\Http\Controllers\Controller;
use App\Interfaces\StandardControllerInterface;
use App\Models\Architecture\Emplacement;
use App\Models\Architecture\Site;
use App\Models\Architecture\Zone;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
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
        $zone = Zone::with('niveau.pavillon', 'emplacements')->findOrFail($id);
        $rang = (string) ($zone->emplacements->count() + 1);
        $place = str_pad($rang, 3, '0', STR_PAD_LEFT);
        $code = $zone->niveau->pavillon->code . $zone->niveau->code . $zone->code . $place;

        return ['code' => $code, 'rang' => $rang];
    }

    /**
     * Undocumented function
     *
     * @param  int  $id
     * @return Builder
     */
    private static function queryByMarche(int $id): Builder
    {
        $query = DB::table('emplacements')->select('emplacements.*')->join('zones', 'zones.id', '=', 'emplacements.zone_id')
            ->join('niveaux', 'zones.niveau_id', '=', 'niveaux.id')->join('pavillons', 'niveaux.pavillon_id', '=', 'pavillons.id')
            ->leftjoin('equipements', 'equipements.emplacement_id', '=', 'emplacements.id')
            ->where('pavillons.site_id', $id, true);

        return $query;
    }

    public function all(): JsonResponse
    {
        $emplacements = Emplacement::with('type', 'zone.niveau.pavillon.site')->get();

        return response()->json(['emplacements' => $emplacements]);
    }

    public function equipables(): JsonResponse
    {
        $emplacements = DB::table('emplacements')->select('emplacements.*', 'pavillons.site_id')
            ->join('zones', 'zones.id', '=', 'emplacements.zone_id')
            ->join('niveaux', 'zones.niveau_id', '=', 'niveaux.id')->join('pavillons', 'niveaux.pavillon_id', '=', 'pavillons.id')
            ->join('type_emplacements', 'type_emplacements.id', '=', 'emplacements.type_emplacement_id')
            ->where('type_emplacements.equipable', true)->get();

        return response()->json(['emplacements' => $emplacements]);
    }

    public function show(int $id): JsonResponse
    {
        $emplacement = Emplacement::with('type', 'zone.niveau.pavillon.site')->findOrFail($id);

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

    public function restore(int $id): JsonResponse
    {
        $emplacement = Emplacement::withTrashed()->find($id);
        $emplacement->restore();
        $message = "L'emplacement $emplacement->nom a été restauré avec succès.";

        return response()->json(['message' => $message]);
    }

    public function trashed(): JsonResponse
    {
        $emplacements = Emplacement::with('zone', 'type')->onlyTrashed()->get();

        return response()->json(['emplacements' => $emplacements]);
    }

    public function trash(int $id): JsonResponse
    {
        $emplacement = Emplacement::findOrFail($id);
        $emplacement->delete();
        $message = "L'emplacement $emplacement->nom a été supprimé avec succès.";

        return response()->json(['message' => $message]);
    }

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
            $emplacement->liberer();
            $emplacement->delier();
            $compteur--;
        }
        $message = "$request->nombre emplacements ont été crées avec succès.";

        return response()->json(['message' => $message]);
    }

    public function getByMarche(int $id): JsonResponse
    {
        $emplacements = self::queryByMarche($id)->get();

        return response()->json(['emplacements' => $emplacements]);
    }

    public function getByMarcheWithGearsLinked(int $id): JsonResponse
    {
        $emplacements = Site::with('emplacements.equipements.type')->findOrFail($id)->emplacements;

        return response()->json(['emplacements' => $emplacements]);
    }

    public function getUnlinkedByMarche(int $id): JsonResponse
    {
        $emplacements = Emplacement::isUnlinked()->get();

        return response()->json(['emplacements' => $emplacements]);
    }

    public function getFreeByMarche(int $id): JsonResponse
    {
        $emplacements = self::queryByMarche($id)->join('statuses', 'statuses.model_id', '=', 'emplacements.id')
        ->where('statuses.name', StatusEmplacement::FREE)->get();
        return response()->json(['emplacements' => $emplacements]);
    }

    public function getBusyByMarche(int $id): JsonResponse
    {
        $emplacements = self::queryByMarche($id)->whereNotNull('date_occupe')->get();

        return response()->json(['emplacements' => $emplacements]);
    }

    public function getRentalbyMonth(string $date): JsonResponse
    {
        $emplacements = DB::table('emplacements')
            ->select('emplacements.*', DB::raw("concat(personnes.nom,' ',personnes.prenom) as alias"))
            ->join('contrats', 'emplacements.id', '=', 'contrats.emplacement_id')
            ->join('personnes', 'personnes.id', '=', 'contrats.personne_id')
            ->leftJoin('factures', 'contrats.id', '=', 'factures.contrat_id')
            ->where('factures.code', 'LIKE', 'FAL%')->whereMonth('factures.periode', '!=', Carbon::parse($date)->format('m'))
            ->whereYear('factures.periode', '!=', Carbon::parse($date)->format('Y'))->orWhereNull('factures.periode')
            ->where('personnes.prospect', false)->distinct()->get();

        return response()->json(['emplacements' => $emplacements]);
    }
}
