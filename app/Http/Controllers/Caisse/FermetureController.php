<?php

namespace App\Http\Controllers\Caisse;

use App\Http\Controllers\Controller;
use App\Http\Resources\Caisse\FermetureListResource;
use App\Http\Resources\Caisse\FermetureResource;
use App\Models\Caisse\Fermeture;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FermetureController extends Controller
{

    public function index(): JsonResponse
    {
        $fermetures = Fermeture::with('ouverture.encaissements.ordonnancement')->get();
        return response()->json(['fermetures' => FermetureListResource::collection($fermetures)]);
    }

    public function getPaginate(): JsonResource
    {
        $fermetures = Fermeture::with('ouverture.encaissements.ordonnancement')->paginate(10);
        return FermetureListResource::collection($fermetures);
    }

    public function getSearch(string $search): JsonResource
    {
        $fermetures = Fermeture::with('ouverture.encaissements.ordonnancement')
            ->whereRaw("DATE_FORMAT(fermetures.created_at,'%d-%m-%Y') LIKE ?", "$search%")
            ->orWhereHas('ouverture.caissier.user', fn(Builder $query) => $query->where('name', 'LIKE', "%$search%"))
            ->orWhereHas('ouverture.guichet', fn(Builder $query) => $query->where('nom', 'LIKE', "%$search%"))
            ->paginate(10);
        return FermetureListResource::collection($fermetures);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(Fermeture::RULES);
        $fermeture = Fermeture::make($request->all());
        $fermeture->codeGenerate();
        $fermeture->save();
        $fermetureSaved = Fermeture::with('ouverture.encaissements.payable')->find($fermeture->id);
        return response()->json([
            'message' => "La caisse a été fermée avec succès.",
            'fermeture' => FermetureResource::make($fermetureSaved),
        ]);
    }

    public function show(int $id)
    {
        $fermeture = Fermeture::with('ouverture.encaissements.payable')->find($id);
        return response()->json(['fermeture' => FermetureResource::make($fermeture)]);
    }
}
