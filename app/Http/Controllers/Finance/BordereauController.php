<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Bordereau;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BordereauController extends Controller
{
    public function all(): JsonResponse
    {
        $bordereaux = Bordereau::with('commercial')->get();
        return response()->json(['bordereaux' => $bordereaux]);
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
        $bordereau = Bordereau::with('attributions.emplacement', 'attributions.collecte', 'commercial')->findOrFail($id);
        return response()->json(['bordereau' => $bordereau]);
    }
}
