<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Resources\Bordereau\CommercialListResource;
use App\Http\Resources\Bordereau\CommercialResource;
use App\Models\Finance\Commercial;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CommercialController extends Controller
{
    public function all(): JsonResponse
    {
        $commerciaux = Commercial::get();
        return response()->json(['commerciaux' => CommercialListResource::collection($commerciaux)]);
    }

    public function select(): JsonResponse
    {
        $commerciaux = Commercial::with(['attributions.emplacement', 'bordereaux'])->without('user.avatar', 'site')->get();
        return response()->json(['commerciaux' => CommercialResource::collection($commerciaux)]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(Commercial::RULES);
        $commercial = new Commercial($request->all());
        $commercial->codeGenerate();
        $commercial->save();
        $message = "Le commercial: $commercial->code a été enregistré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trash(int $id): JsonResponse
    {
        $commercial = Commercial::findOrFail($id);
        $commercial->delete();
        $message = "Le commercial: $commercial->code a été supprimé avec succès.";
        // TODO: lorsque le commercial est supprimé il faut attribuer forcement ces bordereaux à une autre sinon on empêche la suppression
        return response()->json(['message' => $message]);
    }

    public function restore(int $id): JsonResponse
    {
        $commercial = Commercial::withTrashed()->find($id);
        $commercial->restore();
        $message = "Le commercial $commercial->code a été restauré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trashed(): JsonResponse
    {
        $commerciaux = Commercial::onlyTrashed()->get();
        return response()->json(['commerciaux' => $commerciaux]);
    }

    public function show(int $id): JsonResponse
    {
        $commercial = Commercial::with(['attributions.emplacement', 'bordereaux'])->withTrashed()->findOrFail($id);
        return response()->json(['commercial' => CommercialResource::make($commercial)]);
    }

    public function attribuate(Request $request): JsonResponse
    {
        $request->validate(Commercial::ATTRIBUTION_RULES);

        $commercial = Commercial::findOrFail((int)$request->commercial);
        foreach ($request->emplacements as $emplacement) {
            $commercial->attributions()->attach($emplacement['id'], ['jour' => $request->jour]);
        }
        $message = "Emplacement(s) attribué(s) avec succès.";
        return response()->json(['message' => $message]);
    }
}
