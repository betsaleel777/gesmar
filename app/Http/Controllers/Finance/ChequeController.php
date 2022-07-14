<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Cheque;
use Illuminate\Http\Request;

class ChequeController extends Controller
{
    public function all()
    {
        $cheques = Cheque::with('site')->get();
        return response()->json(['cheques' => $cheques]);
    }

    public function store(Request $request)
    {
        $request->validate(Cheque::RULES);
        $cheque = new Cheque($request->all());
        $cheque->save();
        $message = "Le cheque $request->numero a été enrgistré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function update(int $id, Request $request)
    {
        $request->validate(Cheque::RULES);
        $cheque = Cheque::find($id);
        $cheque->update($request->all());
        $message = "Le cheque a été modifié avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trash(int $id)
    {
        $cheque = Cheque::find($id);
        $cheque->delete();
        $message = "Le chèque: $cheque->numero a été supprimé avec succès.";
        return response()->json(['message' => $message]);
    }

    public function restore(int $id)
    {
        $cheque = Cheque::withTrashed()->find($id);
        $cheque->restore();
        $message = "Le chèque $cheque->nom a été restauré avec succès.";
        return response()->json(['message' => $message]);

    }

    public function trashed()
    {
        $cheques = Cheque::with('site')->onlyTrashed()->get();
        return response()->json(['cheques' => $cheques]);
    }

    public function show(int $id)
    {
        $cheque = Cheque::with('site')->withTrashed()->find($id);
        return response()->json(['cheque' => $cheque]);
    }
}
