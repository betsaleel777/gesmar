<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Http\Resources\Emplacement\EmplacementFactureLoyerResource;
use App\Http\Resources\Emplacement\EmplacementListResource;
use App\Http\Resources\Emplacement\EmplacementResource;
use App\Http\Resources\Emplacement\EmplacementSelectResource;
use App\Http\Resources\Emplacement\EmplacementSimpleSelectResource;
use App\Models\Architecture\Emplacement;
use App\Models\Architecture\Zone;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class EmplacementsController extends Controller
{
    /**
     * Génerer le code de l'emplacement
     *
     * @param  int  $id
     * @return array<string, string>
     */
    private static function codeGenerate(int $id): array
    {
        $zone = Zone::with('emplacements')->find($id);
        $rang = (string) ($zone->emplacements->count() + 1);
        $place = str_pad($rang, 3, '0', STR_PAD_LEFT);
        $code = $zone->getCode() . $place;
        return ['code' => $code, 'rang' => $rang];
    }

    public function all(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Emplacement::class);
        $requete = Emplacement::select('id', 'code', 'superficie', 'loyer', 'pas_porte', 'disponibilite', 'liaison', 'type_emplacement_id')
            ->with(['type' => fn(BelongsTo $query): BelongsTo => $query->select('id', 'nom')]);
        if ($response->allowed()) {
            $emplacements = $requete->get();
        } else {
            $sites = Auth::user()->sites->modelkeys();
            $emplacements = $requete->inside($sites)->get();
        }
        return response()->json(['emplacements' => EmplacementListResource::collection($emplacements)]);
    }

    public function select(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Emplacement::class);
        if ($response->allowed()) {
            $emplacements = Emplacement::with('zone', 'niveau', 'pavillon', 'site')->get();
        } else {
            $sites = Auth::user()->sites->modelkeys();
            $emplacements = Emplacement::with('zone', 'niveau', 'pavillon', 'site')->inside($sites)->get();
        }
        return response()->json(['emplacements' => EmplacementSelectResource::collection($emplacements)]);
    }

    public function simpleSelect(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Emplacement::class);
        if ($response->allowed()) {
            $emplacements = Emplacement::without('type')->get();
        } else {
            $sites = Auth::user()->sites->modelkeys();
            $emplacements = Emplacement::without('type')->inside($sites)->get();
        }
        return response()->json(['emplacements' => EmplacementSimpleSelectResource::collection($emplacements)]);
    }

    public function allAuto(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Emplacement::class);
        if ($response->allowed()) {
            $emplacements = Emplacement::with('zone', 'niveau', 'pavillon', 'site')->withoutSchedule()->get();
        } else {
            $sites = Auth::user()->sites->modelkeys();
            $emplacements = Emplacement::with('zone', 'niveau', 'pavillon', 'site')->withoutSchedule()->inside($sites)->get();
        }
        return response()->json(['emplacements' => $emplacements]);
    }

    public function allAutoBySite(Request $request): JsonResource
    {
        $emplacements = Emplacement::select('id', 'code', 'zone_id', 'type_emplacement_id')
            ->with('zone:zones.id,zones.nom,niveau_id', 'niveau:niveaux.id,niveaux.nom,pavillon_id',
                'pavillon:pavillons.id,pavillons.nom,site_id', 'site:sites.id,sites.nom')
            ->removeOtherAlreadyAssignedToBordereau($request->integer('site'), $request->integer('commercial'), $request->jour)
            ->whereHas('site', fn(Builder $query): Builder => $query->where('sites.id', $request->site))
            ->removeAlreadyCollected($request->jour)->withoutSchedule()->get();
        return EmplacementListResource::collection($emplacements);
    }

    public function equipables(): JsonResponse
    {
        $emplacements = DB::table('emplacements')->select(['emplacements.*', 'pavillons.site_id'])
            ->join('zones', 'zones.id', '=', 'emplacements.zone_id')
            ->join('niveaux', 'zones.niveau_id', '=', 'niveaux.id')
            ->join('pavillons', 'niveaux.pavillon_id', '=', 'pavillons.id')
            ->join('type_emplacements', 'type_emplacements.id', '=', 'emplacements.type_emplacement_id')
            ->where('type_emplacements.equipable', true)->get();
        return response()->json(['emplacements' => $emplacements]);
    }

    public function show(int $id): JsonResponse
    {
        $emplacement = Emplacement::with(['type', 'zone.niveau.pavillon.site'])->findOrFail($id);
        $this->authorize('view', $emplacement);
        return response()->json(['emplacement' => $emplacement]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Emplacement::class);
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
        $emplacement = Emplacement::findOrFail($id);
        $this->authorize('update', $emplacement);
        $request->validate(Emplacement::RULES);
        $emplacement->update($request->all());
        $message = "L'emplacement $request->nom a été modifié avec succès.";
        return response()->json(['message' => $message]);
    }

    public function restore(int $id): JsonResponse
    {
        $emplacement = Emplacement::withTrashed()->find($id);
        $this->authorize('restore', $emplacement);
        $emplacement->restore();
        $message = "L'emplacement $emplacement->nom a été restauré avec succès.";
        return response()->json(['message' => $message]);
    }

    /**
     * Liste des emplacements archivés
     */
    public function trashed(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Emplacement::class);
        if ($response->allowed()) {
            $emplacements = Emplacement::with('zone')->onlyTrashed()->get();
        } else {
            $sites = Auth::user()->sites->modelkeys();
            $emplacements = Emplacement::with('zone')->inside($sites)->onlyTrashed()->get();
        }
        return response()->json(['emplacements' => $emplacements]);
    }

    /**
     * Archivage d'emplacement
     */
    public function trash(int $id): JsonResponse
    {
        $emplacement = Emplacement::findOrFail($id);
        $this->authorize('delete', $emplacement);
        $emplacement->delete();
        $message = "L'emplacement $emplacement->nom a été supprimé avec succès.";
        return response()->json(['message' => $message]);
    }

    /**
     * Insertion massive d'emplacement de même attributs
     *
     */
    public function push(Request $request): JsonResponse
    {
        $this->authorize('create', Emplacement::class);
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
     */
    public function getByMarche(int $id): JsonResponse
    {
        $emplacements = Emplacement::whereHas('site', fn(Builder $query) => $query->where('sites.id', $id))->get();
        return response()->json(['emplacements' => $emplacements]);
    }

    public function getByMarcheSelect(int $id): JsonResponse
    {
        $emplacements = Emplacement::select('id', 'nom', 'code')
            ->whereHas('site', fn(Builder $query) => $query->where('sites.id', $id))->get();
        return response()->json(['emplacements' => EmplacementSimpleSelectResource::collection($emplacements)]);
    }

    /**
     * Récupère les emplacements selon l'id d'un marché et l'existence d'un contrat non résilié en chargeant les équipements liés et leurs types
     */
    public function getByMarcheWithGearsAndContracts(int $id): JsonResponse
    {
        $emplacements = Emplacement::with('equipements.type:id,nom')->whereHas('contrats', fn(Builder $query) => $query->notAborted())
            ->whereHas('site', fn(Builder $query) => $query->where('sites.id', $id))->get();
        return response()->json(['emplacements' => EmplacementResource::collection($emplacements)]);
    }

    /**
     * Récupère les emplacements lié à aucun équipement selon le site (marché)
     */
    public function getUnlinkedByMarche(int $id): JsonResponse
    {
        $emplacements = Emplacement::isUnlinked()->whereHas('site', fn(Builder $query) => $query->where('sites.id', $id))->get();
        return response()->json(['emplacements' => EmplacementResource::collection($emplacements)]);
    }

    /**
     * Récupère les emplacements libre selon le site
     */
    public function getFreeByMarche(int $id): JsonResponse
    {
        $emplacements = Emplacement::isFree()->whereHas('site', fn(Builder $query) => $query->where('sites.id', $id))->get();
        return response()->json(['emplacements' => EmplacementResource::collection($emplacements)]);
    }

    /**
     * Récupère les emplacements occupés selon le site
     */
    public function getBusyByMarche(int $id): JsonResponse
    {
        $emplacements = Emplacement::isBusy()->whereHas('site', fn($query) => $query->where('sites.id', $id))->get();
        return response()->json(['emplacements' => EmplacementResource::collection($emplacements)]);
    }

    public function getRentalbyMonthLoyer(string $date): JsonResponse
    {
        $emplacements = Emplacement::with(['contratActuel' => ['facturesLoyers', 'personne']])
            ->without('type')->whereHas('contratActuel', fn(Builder $query) => $query->where('auto_valid', false))
            ->whereDoesntHave('contratActuel.facturesLoyers', fn(Builder $query) => $query->where('periode', $date))->get();
        return response()->json(['emplacements' => EmplacementFactureLoyerResource::collection($emplacements)]);
    }

    public function getByZones(Request $request)
    {
        $emplacements = Emplacement::select('id', 'code', 'zone_id', 'type_emplacement_id')
            ->with('zone:zones.id,zones.nom,niveau_id', 'niveau:niveaux.id,niveaux.nom,pavillon_id',
                'pavillon:pavillons.id,pavillons.nom,site_id', 'site:sites.id,sites.nom')
            ->with(['type' => fn($query) => $query->select('type_emplacements.id', 'type_emplacements.nom')])
            ->whereHas('zone', fn($query) => $query->whereIn('zones.id', $request->query('zones')))
            ->removeAlreadyAssignedToBordereau($request->integer('site'), $request->jour)
            ->removeAlreadyCollected($request->jour)->withoutSchedule()->get();
        return response()->json(['emplacements' => EmplacementListResource::collection($emplacements)]);
    }
}
