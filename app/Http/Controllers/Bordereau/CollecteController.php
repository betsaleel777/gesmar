<?php

namespace App\Http\Controllers\Bordereau;

use App\Http\Controllers\Controller;
use App\Http\Requests\BordereauCollectRequest;
use App\Http\Resources\Bordereau\CollecteResource;
use App\Models\Bordereau\Collecte;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollecteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResource
    {
        $collectes = Collecte::get();
        return CollecteResource::collection($collectes);
    }

    public function getAlreadyCollected(Request $request): JsonResource
    {
        $collectes = Collecte::where('bordereau_id', $request->bordereau)->where('emplacement_id', $request->emplacement)->get();
        return CollecteResource::collection($collectes);
    }

    public function getAlreadyGlobaleCollected(Request $request): JsonResource
    {
        $collectes = Collecte::where('emplacement_id', $request->emplacement)
            ->whereBetween('jour', [Carbon::parse($request->jour)->subDays(15), Carbon::parse($request->jour)->addDays(15)])->get();
        return CollecteResource::collection($collectes);
    }

    public function store(BordereauCollectRequest $request): JsonResponse
    {
        $request->validated();
        $insertData = collect([]);
        foreach ($request->jours as $jour) {
            $insertData->push([
                'bordereau_id' => $request->bordereau_id,
                'emplacement_id' => $request->emplacement['id'],
                'montant' => $request->emplacement['loyer'],
                'jour' => $jour,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        Collecte::insert($insertData->toArray());
        return response()->json("Collecte enregistrée avec succès.");
    }
}
