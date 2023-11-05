<?php

namespace App\Http\Controllers;

use App\Http\Resources\Bordereau\BordereauListResource;
use App\Http\Resources\Bordereau\BordereauResource;
use App\Models\Bordereau\Bordereau;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class BordereauController extends Controller
{
    public function index(): JsonResponse
    {
        $bordereaux = Bordereau::with(['commercial:id,user_id' => ['user:id,name'], 'site:id,nom'])->get();
        return response()->json(['bordereau' => BordereauResource::collection($bordereaux)]);
    }

    public function getPaginate(): JsonResource
    {
        $bordereaux = Bordereau::with(['commercial:id,user_id' => ['user:id,name'], 'site:id,nom'])->paginate(10);
        return BordereauListResource::collection($bordereaux);
    }

    public function getSearch(string $search): JsonResource
    {
        $bordereaux = Bordereau::with(['commercial:id,user_id' => ['user:id,name'], 'site:id,nom'])
            ->where('status', 'LIKE', "%$search%")->orWhere('jour', 'LIKE', "%$search")
            ->orWhereHas('commercial.user', fn($query) => $query->where('name', 'LIKE', "%$search%"))
            ->orWhereHas('site', fn($query) => $query->where('nom', 'LIKE', "%$search%"))
            ->paginate(10);
        return BordereauListResource::collection($bordereaux);
    }

    public function show(Bordereau $bordereau): JsonResponse
    {
        $bordereau->load(['commercial:id,user_id' => ['user:id,name'], 'site:id,nom', 'emplacements']);
        return response()->json(['bordereau' => BordereauResource::make($bordereau)]);
    }

    public function destroy(): JsonResponse
    {
        return response()->json();
    }
}
