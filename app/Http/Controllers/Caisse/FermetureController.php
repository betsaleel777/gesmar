<?php

namespace App\Http\Controllers\Caisse;

use App\Http\Controllers\Controller;
use App\Http\Resources\Caisse\FermetureListResource;
use App\Http\Resources\Caisse\FermetureResource;
use App\Models\Caisse\Fermeture;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FermetureController extends Controller
{

    public function index(): JsonResponse
    {
        $fermetures = Fermeture::with('ouverture.encaissements.ordonnancement')->get();
        return response()->json(['fermetures' => FermetureListResource::collection($fermetures)]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(Fermeture::RULES);
        $fermeture = Fermeture::make($request->all());
        $fermeture->save();
        $fermetureSaved = Fermeture::with('ouverture.encaissements.payable')->find($fermeture->id);
        return response()->json([
            'message' => "La caisse a été fermée avec succès.",
            'fermeture' => FermetureResource::make($fermetureSaved)
        ]);
    }

    public function show(int $id)
    {
        $fermeture = Fermeture::with('ouverture.encaissements.payable')->find($id);
        return response()->json(['fermeture' => FermetureResource::make($fermeture)]);
    }
}
