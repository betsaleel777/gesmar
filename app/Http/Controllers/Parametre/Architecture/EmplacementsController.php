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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class EmplacementsController extends Controller
{
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
            ->with('type:id,nom');
        $emplacements = $response->allowed() ? $requete->get() : $requete->owner()->get();
        return response()->json(['emplacements' => EmplacementListResource::collection($emplacements)]);
    }

    public function select(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Emplacement::class);
        $query = Emplacement::with('zone', 'niveau', 'pavillon', 'site');
        $emplacements = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['emplacements' => EmplacementSelectResource::collection($emplacements)]);
    }

    public function simpleSelect(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Emplacement::class);
        $emplacements = $response->allowed() ? Emplacement::get() : Emplacement::owner()->get();
        return response()->json(['emplacements' => EmplacementSimpleSelectResource::collection($emplacements)]);
    }

    public function allAuto(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Emplacement::class);
        $query = Emplacement::with('zone', 'niveau', 'pavillon', 'site')->withoutSchedule();
        $emplacements = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['emplacements' => $emplacements]);
    }

    public function allAutoBySite(Request $request): JsonResource
    {
        $response = Gate::inspect('viewAny', Emplacement::class);
        $query = Emplacement::select('id', 'code', 'zone_id', 'type_emplacement_id')
            ->with(
                'zone:zones.id,zones.nom,niveau_id',
                'niveau:niveaux.id,niveaux.nom,pavillon_id',
                'pavillon:pavillons.id,pavillons.nom,site_id',
                'site:sites.id,sites.nom'
            )
            ->removeOtherAlreadyAssignedToBordereau($request->integer('site'), $request->integer('commercial'), $request->jour)
            ->whereHas('site', fn (Builder $query): Builder => $query->where('sites.id', $request->site))
            ->removeAlreadyCollected($request->jour)->withoutSchedule();
        $emplacements = $response->allowed() ? $query->get() : $query->owner()->get();
        return EmplacementListResource::collection($emplacements);
    }

    public function equipables(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Emplacement::class);
        $query = Emplacement::with('type:id,nom')->whereHas('type', fn (Builder $query): Builder => $query->where('equipable', true));
        $emplacements = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['emplacements' => $emplacements]);
    }

    public function show(int $id): JsonResponse
    {
        $emplacement = Emplacement::with(['type', 'zone.niveau.pavillon.site'])->find($id);
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
        return response()->json(['message' => "L'emplacement $request->nom a été crée avec succès."]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $emplacement = Emplacement::findOrFail($id);
        $this->authorize('update', $emplacement);
        $request->validate(Emplacement::RULES);
        $emplacement->update($request->all());
        return response()->json(['message' => "L'emplacement $request->nom a été modifié avec succès."]);
    }

    public function restore(int $id): JsonResponse
    {
        $emplacement = Emplacement::withTrashed()->find($id);
        $this->authorize('restore', $emplacement);
        $emplacement->restore();
        return response()->json(['message' => "L'emplacement $emplacement->nom a été restauré avec succès."]);
    }

    /**
     * Liste des emplacements archivés
     */
    public function trashed(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Emplacement::class);
        $query = Emplacement::with('zone')->onlyTrashed();
        $emplacements = $response->allowed() ? $query->get() : $query->owner()->get();
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
        return response()->json(['message' => "L'emplacement $emplacement->nom a été supprimé avec succès."]);
    }

    /**
     * Insertion massive d'emplacement de même attributs
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
        return response()->json(['message' => "$request->nombre emplacements ont été crées avec succès."]);
    }

    /**
     * Récupère tout les emplacements dans un marché ou site spécifié
     */
    public function getByMarche(int $id): JsonResponse
    {
        $response = Gate::inspect('viewAny', Emplacement::class);
        $query = Emplacement::bySite($id);
        $emplacements = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['emplacements' => $emplacements]);
    }

    public function getByMarcheSelect(int $id): JsonResponse
    {
        $response = Gate::inspect('viewAny', Emplacement::class);
        $query = Emplacement::select('id', 'nom', 'code')->bySite($id);
        $emplacements = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['emplacements' => EmplacementSimpleSelectResource::collection($emplacements)]);
    }

    /**
     * Récupère les emplacements selon l'id d'un marché et l'existence d'un contrat non résilié en chargeant les équipements liés et leurs types
     */
    public function getByMarcheWithGearsAndContracts(int $id): JsonResponse
    {
        $response = Gate::inspect('viewAny', Emplacement::class);
        $query = Emplacement::with('equipements.type:id,nom')
            ->whereHas('contrats', fn (Builder $query) => $query->notAborted())->bySite($id);
        $emplacements = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['emplacements' => EmplacementResource::collection($emplacements)]);
    }

    /**
     * Récupère les emplacements lié à aucun équipement selon le site (marché)
     */
    public function getUnlinkedByMarche(int $id): JsonResponse
    {
        $response = Gate::inspect('viewAny', Emplacement::class);
        $query = Emplacement::isUnlinked()->bySite($id);
        $emplacements = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['emplacements' => EmplacementResource::collection($emplacements)]);
    }

    /**
     * Récupère les emplacements libre selon le site
     */
    public function getFreeByMarche(int $id): JsonResponse
    {
        $response = Gate::inspect('viewAny', Emplacement::class);
        $query = Emplacement::isFree()->bySite($id);
        $emplacements = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['emplacements' => EmplacementResource::collection($emplacements)]);
    }

    /**
     * Récupère les emplacements libre selon le site et la personne
     */
    public function getFreeByMarchePersonne(int $marche, int $personne): JsonResponse
    {
        Log::alert($marche);
        Log::alert($personne);
        $response = Gate::inspect('viewAny', Emplacement::class);
        $query = Emplacement::isFree()->bySite($marche)->byPersonneWithoutPending($personne);
        $emplacements = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['emplacements' => EmplacementResource::collection($emplacements)]);
    }

    /**
     * Récupère les emplacements occupés selon le site
     */
    public function getBusyByMarche(int $id): JsonResponse
    {
        $response = Gate::inspect('viewAny', Emplacement::class);
        $query = Emplacement::isBusy()->bySite($id);
        $emplacements = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['emplacements' => EmplacementResource::collection($emplacements)]);
    }

    public function getRentalbyMonthLoyer(string $date): JsonResponse
    {
        $response = Gate::inspect('viewAny', Emplacement::class);
        $query = Emplacement::with(['contratActuel' => ['facturesLoyers', 'personne']])
            ->whereHas('contratActuel', fn (Builder $query) => $query->where('auto_valid', false)->leadExceeded($date))
            ->whereDoesntHave('contratActuel.facturesLoyers', fn (Builder $query) => $query->where('periode', $date));
        $emplacements = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['emplacements' => EmplacementFactureLoyerResource::collection($emplacements)]);
    }

    public function getByZones(Request $request)
    {
        $response = Gate::inspect('viewAny', Emplacement::class);
        $query = Emplacement::select('id', 'code', 'zone_id', 'type_emplacement_id')
            ->with(
                'zone:zones.id,zones.nom,niveau_id',
                'niveau:niveaux.id,niveaux.nom,pavillon_id',
                'pavillon:pavillons.id,pavillons.nom,site_id',
                'site:sites.id,sites.nom'
            )
            ->with(['type' => fn ($query) => $query->select('type_emplacements.id', 'type_emplacements.nom')])
            ->whereHas('zone', fn ($query) => $query->whereIn('zones.id', $request->query('zones')))
            ->removeAlreadyAssignedToBordereau($request->integer('site'), $request->jour)
            ->removeAlreadyCollected($request->jour)->withoutSchedule();
        $emplacements = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['emplacements' => EmplacementListResource::collection($emplacements)]);
    }
}
