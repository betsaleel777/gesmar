<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Resources\Bordereau\BordereauListResource;
use App\Http\Resources\Bordereau\BordereauResource;
use App\Http\Resources\Bordereau\BordereauSelectResource;
use App\Http\Resources\Bordereau\BordereauVueEncaissementResource;
use App\Models\Finance\Bordereau;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class BordereauController extends Controller
{
    public function all(): JsonResponse
    {
        $bordereaux = Bordereau::with('commercial')->get();
        return response()->json(['bordereaux' => BordereauListResource::collection($bordereaux)]);
    }

    public function getCollected(): JsonResponse
    {
        $bordereaux = Bordereau::select('id', 'code')->isCollected()->get();
        return response()->json(['bordereaux' => BordereauSelectResource::collection($bordereaux)]);
    }

    public function getSearch(string $search): JsonResource
    {
        $bordereaux = Bordereau::with('commercial')->where('code', 'LIKE', "%$search%")
            ->orWhere('date_attribution', 'LIKE', "%$search")
            ->orWhereHas('commercial.user', fn (Builder $query) => $query->where('name', 'LIKE', "%$search%"))
            ->paginate(10);
        return BordereauListResource::collection($bordereaux);
    }

    public function getPaginate(): JsonResource
    {
        $bordereaux = Bordereau::with('commercial')->paginate(10);
        return BordereauListResource::collection($bordereaux);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(Bordereau::RULES);
        $bordereau = new Bordereau($request->all());
        $bordereau->codeGenerate();
        $bordereau->save();
        $bordereau->pasEncaisser();
        $message = "Le bordereau $bordereau->code a été crée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function show(int $id): JsonResponse
    {
        $bordereau = Bordereau::with(['attributions.emplacement', 'attributions.collecte', 'commercial'])->findOrFail($id);
        return response()->json(['bordereau' => BordereauResource::make($bordereau)]);
    }

    public function getForEncaissement(int $id): JsonResponse
    {
        $bordereau = Bordereau::with('attributions.collecte', 'commercial.user')->find($id);
        return response()->json(['bordereau' => BordereauVueEncaissementResource::make($bordereau)]);
    }
}
