<?php

namespace App\Http\Controllers\Caisse;

use App\Events\FermetureRegistred;
use App\Events\FermetureValidated;
use App\Http\Controllers\Controller;
use App\Http\Requests\FermetureValidationRequest;
use App\Http\Resources\Caisse\FermetureListResource;
use App\Http\Resources\Caisse\FermetureResource;
use App\Models\Caisse\Fermeture;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

class FermetureController extends Controller
{

    public function index(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Fermeture::class);
        $query = Fermeture::with('ouverture.encaissements.ordonnancement');
        $fermetures = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['fermetures' => FermetureListResource::collection($fermetures)]);
    }

    public function getPaginate(): JsonResource
    {
        $response = Gate::inspect('viewAny', Fermeture::class);
        $query = Fermeture::with('guichet:guichets.id,guichets.nom', 'caissier:caissiers.id,caissiers.user_id', 'caissier.user:id,name');
        $fermetures = $response->allowed() ? $query->paginate(10) : $query->owner()->paginate(10);
        return FermetureListResource::collection($fermetures);
    }

    public function getSearch(string $search): JsonResource
    {
        $response = Gate::inspect('viewAny', Fermeture::class);
        $query = Fermeture::with('guichet:guichets.id,guichets.nom', 'caissier:caissiers.id,caissiers.user_id', 'caissier.user:id,name')
            ->whereRaw("DATE_FORMAT(fermetures.created_at,'%d-%m-%Y') LIKE ?", "$search%")
            ->orWhereHas('guichet', fn(Builder $query) => $query->where('guichets.nom', 'LIKE', "%$search%"))
            ->orWhereHas('caissier.user', fn(Builder $query) => $query->where('users.name', 'LIKE', "%$search%"));
        $fermetures = $response->allowed() ? $query->paginate(10) : $query->owner()->paginate(10);
        return FermetureListResource::collection($fermetures);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Fermeture::class);
        $request->validate(Fermeture::RULES);
        $fermeture = Fermeture::make($request->all());
        $fermeture->codeGenerate();
        $fermeture->save();
        $fermeture->setPending();
        FermetureRegistred::dispatch($fermeture);
        $fermeture->load('ouverture.encaissements.payable');
        return response()->json([
            'message' => "La caisse a été fermée avec succès.",
            'fermeture' => FermetureResource::make($fermeture),
        ]);
    }

    public function valider(FermetureValidationRequest $request): JsonResponse
    {
        $request->validated();
        $fermeture = Fermeture::find($request->id);
        FermetureValidated::dispatch($fermeture, $request->only('perte', 'raison'));
        $message = (int) $request->perte === 0 ? "Le point de caisse $fermeture->code a été validé sans perte" : "Le point de caisse $fermeture->code a été validé avec une perte de $request->perte FCFA";
        return response()->json(['message' => $message]);
    }

    public function show(int $id): JsonResponse
    {
        $fermeture = Fermeture::with('ouverture.encaissements.payable')->find($id);
        $this->authorize('view', Fermeture::class);
        return response()->json(['fermeture' => FermetureResource::make($fermeture)]);
    }
}
