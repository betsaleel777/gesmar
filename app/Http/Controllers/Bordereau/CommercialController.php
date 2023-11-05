<?php

namespace App\Http\Controllers\Bordereau;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignationRequest;
use App\Http\Resources\Bordereau\CommercialListResource;
use App\Http\Resources\Bordereau\CommercialResource;
use App\Http\Resources\Bordereau\CommercialSelectResource;
use App\Models\Bordereau\Bordereau;
use App\Models\Bordereau\Commercial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommercialController extends Controller
{
    public function all(): JsonResponse
    {
        $commerciaux = Commercial::with('user', 'site')->get();
        return response()->json(['commerciaux' => CommercialListResource::collection($commerciaux)]);
    }

    public function getSelect(): JsonResponse
    {
        $commerciaux = Commercial::select('id', 'code', 'user_id')->with([
            'user' => fn($query) => $query->select('id', 'name')->without('avatar'),
        ])->get();
        return response()->json(['commerciaux' => CommercialSelectResource::collection($commerciaux)]);
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

    public function attribuer(AssignationRequest $request): JsonResponse
    {
        $bordereau = Bordereau::make($request->validated());
        $bordereau->codeGenerate();
        $bordereau->save();
        $bordereau->emplacements()->attach($request->emplacements);
        $commercial = Commercial::with('user:id,name')->find($request->commercial_id);
        return response()->json(['message' =>
            "Le bordereau $bordereau->code a été assigné avec succès au commercial " . str($commercial->user->name)->lower()]);
    }

    public function trash(int $id): JsonResponse
    {
        $commercial = Commercial::find($id);
        $commercial->delete();
        $message = "Le commercial: $commercial->code a été supprimé avec succès.";
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
        $commercial = Commercial::with('user', 'site')->find($id);
        return response()->json(['commercial' => CommercialResource::make($commercial)]);
    }
}
