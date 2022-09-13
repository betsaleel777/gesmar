<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Interfaces\WithoutTrashControllerInterface;
use App\Models\Architecture\Abonnement;
use App\Models\Architecture\ValidationAbonnement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ValidationAbonnementController extends Controller implements WithoutTrashControllerInterface
{

    private static function statusChange(Request $request, ValidationAbonnement $validation)
    {
        if ($request->boolean('verdict')) {
            $validation->confirmer();
            $abonnement = Abonnement::find($validation->abonnement_id);
            $abonnement->process();
        } else {
            $validation->rejeter();
        }
    }

    public function all(): JsonResponse
    {
        $validations = ValidationAbonnement::all();
        return response()->json(['validations' => $validations]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(ValidationAbonnement::RULES);
        $validation = new ValidationAbonnement($request->all());
        $validation->save();
        self::statusChange($request, $validation);
        $abonnement = Abonnement::findOrFail($request->abonnement_id);
        $message = "L'abonnemnt $abonnement->code a été confirmé avec succès.";
        return response()->json(['message' => $message]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $request->validate(ValidationAbonnement::RULES);
        $validation = ValidationAbonnement::with('abonnement')->findOrfail($id);
        $validation->update($request->all());
        self::statusChange($request, $validation);
        $message = "L'abonnemnt $validation->abonnement->code a été modifié avec succès.";
        return response()->json(['message' => $message]);
    }

    public function show(int $id): JsonResponse
    {
        $validation = ValidationAbonnement::with('abonnement')->findOrfail($id);
        return response()->json(['validation' => $validation]);
    }
}
