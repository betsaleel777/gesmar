<?php

namespace App\Http\Controllers\Bordereau;

use App\Http\Controllers\Controller;
use App\Http\Requests\BordereauRequest;
use App\Http\Resources\Bordereau\BordereauListResource;
use App\Http\Resources\Bordereau\BordereauResource;
use App\Models\Bordereau\Bordereau;
use App\Models\Bordereau\Collecte;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

class BordereauController extends Controller
{
    public function index(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Bordereau::class);
        $query = Bordereau::with('site:id,nom', 'commercial:id,user_id', 'commercial.user:id,name');
        $bordereaux = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['bordereau' => BordereauResource::collection($bordereaux)]);
    }

    public function getPaginate(): JsonResource
    {
        $response = Gate::inspect('viewAny', Bordereau::class);
        $query = Bordereau::with('site:id,nom', 'commercial:id,user_id', 'commercial.user:id,name');
        $bordereaux = $response->allowed() ? $query->paginate(10) : $query->owner()->paginate(10);
        return BordereauListResource::collection($bordereaux);
    }

    public function getSearch(string $search): JsonResource
    {
        $response = Gate::inspect('viewAny', Bordereau::class);
        $query = Bordereau::with('site:id,nom', 'commercial:id,user_id', 'commercial.user:id,name')
            ->whereRaw("DATE_FORMAT(bordereaux.created_at,'%d-%m-%Y') LIKE ?", "$search%")
            ->orWhere('code', 'LIKE', "%$search%")
            ->orWhereHas('commercial.user', fn (Builder $query): Builder => $query->where('name', 'LIKE', "%$search%"));
        $bordereaux = $response->allowed() ? $query->paginate(10) : $query->owner()->paginate(10);
        return BordereauListResource::collection($bordereaux);
    }

    public function show(int $id): JsonResponse
    {
        $bordereau = Bordereau::select('id', 'code', 'commercial_id', 'created_at', 'jour')->withSum('collectes as total', 'montant')
            ->with('commercial:id,user_id', 'commercial.user:id,name')
            ->with([
                'emplacements' => fn ($query) => $query->select('emplacements.id', 'emplacements.code', 'emplacements.loyer')
                    ->addSelect(['montant' => Collecte::query()->selectRaw("sum(montant) as montant")->groupBy('emplacement_id')
                        ->whereColumn('emplacement_id', 'emplacements.id')->where('bordereau_id', $id)]),
            ])->find($id);
        $this->authorize('view', $bordereau);
        return response()->json(['bordereau' => BordereauResource::make($bordereau)]);
    }

    public function getEdit(int $id): JsonResource
    {
        $bordereau = Bordereau::select('id', 'code', 'commercial_id', 'jour', 'site_id')
            ->with('commercial.user:id,name', 'commercial:id,user_id')
            ->with([
                'emplacements' => fn (BelongsToMany $query): BelongsToMany =>
                $query->select('emplacements.id', 'emplacements.code', 'emplacements.created_at', 'emplacements.zone_id', 'emplacements.loyer')
                    ->with(
                        'zone:zones.id,zones.nom,niveau_id',
                        'niveau:niveaux.id,niveaux.nom,pavillon_id',
                        'pavillon:pavillons.id,pavillons.nom,site_id',
                        'site:sites.id,sites.nom'
                    ),
            ])->find($id);
        $this->authorize('view', $bordereau);
        return BordereauResource::make($bordereau);
    }

    public function getOneForCollecte(int $id): JsonResource
    {
        $calebasse = Bordereau::select('jour')->find($id);
        $bordereau = Bordereau::select('id', 'code', 'commercial_id', 'jour')->with('commercial.user:id,name', 'commercial:id,user_id')
            ->with([
                'emplacements' => fn (BelongsToMany $query): BelongsToMany =>
                $query->select('emplacements.id', 'emplacements.code', 'emplacements.loyer')->removeAlreadyCollected($calebasse->jour),
            ])->find($id);
        $this->authorize('view', $bordereau);
        return BordereauResource::make($bordereau);
    }

    public function update(int $id, BordereauRequest $request): JsonResponse
    {
        $bordereau = Bordereau::find($id);
        $this->authorize('update', $bordereau);
        $request->validated();
        $syncs = collect($request->emplacements)->mapWithKeys(fn ($emplacement) => [$emplacement['id'] => ['loyer' => $emplacement['loyer']]]);
        $bordereau->emplacements()->sync($syncs->toArray());
        return response()->json(['message' => "Le bordereau $bordereau->code du commercial a été modifié avec succès."]);
    }

    public function getUncashed(): JsonResource
    {
        $response = Gate::inspect('viewAny', Bordereau::class);
        $query = Bordereau::uncashed();
        $bordereaux = $response->allowed() ? $query->get() : $query->owner()->get();
        return BordereauResource::collection($bordereaux);
    }

    public function getForCashout(): JsonResource
    {
        $response = Gate::inspect('viewAny', Bordereau::class);
        $query = Bordereau::has('collectes')->uncashed();
        $bordereaux = $response->allowed() ? $query->get() : $query->owner()->get();
        return BordereauResource::collection($bordereaux);
    }

    public function getOneForCashout(int $id): JsonResource
    {
        $bordereau = Bordereau::select('id', 'code', 'jour', 'commercial_id')->withSum('collectes as total', 'montant')
            ->with('commercial:id,user_id', 'commercial.user:id,name')->find($id);
        $this->authorize('view', $bordereau);
        return BordereauResource::make($bordereau);
    }
}
