<?php

namespace App\Http\Controllers\Caisse;

use App\Http\Controllers\Controller;
use App\Http\Resources\Caisse\FermetureListResource;
use App\Models\Caisse\Encaissement;
use App\Models\Caisse\Fermeture;
use App\Models\Caisse\Ouverture;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FermetureController extends Controller
{
    public function __construct(
        private Fermeture $fermeture
    ) {
    }

    public function index(): JsonResponse
    {
        $fermetures = $this->fermeture->with('ordonnacement')->get();
        return response()->json(['fermetures' => FermetureListResource::make($fermetures)]);
    }

    public function store(Request $request): JsonResponse
    {
        $query = Encaissement::opened();
        if ($query->exists()) {
            $encaissements = $query->get();
            $this->fermeture->make();
            $this->fermeture->codeGenerate();
            $this->fermeture->save();
            foreach ($encaissements->all() as $encaissement) {
                $this->fermeture->encaissements()->attach($encaissement->id);
            }
            $ouverture = Ouverture::find($this->fermeture->ouverture_id);
            $ouverture->setConfirmed();
            return response()->json(['message' => "L'ouverture de caisse $ouverture->code a été fermée avec succès."]);
        }
    }
}
