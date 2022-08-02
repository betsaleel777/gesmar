<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Cheque;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChequeController extends Controller
{
    public function all(): JsonResponse
    {
        $cheques = Cheque::get();

        return response()->json(['cheques' => $cheques]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(Cheque::RULES);
        $cheque = new Cheque($request->all());
        $cheque->save();
        $message = "Le cheque $request->numero a été enrgistré avec succès.";

        return response()->json(['message' => $message]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $request->validate(Cheque::RULES);
        $cheque = Cheque::findOrFail($id);
        $cheque->update($request->all());
        $message = 'Le cheque a été modifié avec succès.';

        return response()->json(['message' => $message]);
    }

    public function show(int $id): JsonResponse
    {
        $cheque = Cheque::find($id);

        return response()->json(['cheque' => $cheque]);
    }
}
