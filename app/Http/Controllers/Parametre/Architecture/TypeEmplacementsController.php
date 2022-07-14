<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Interfaces\StandardControllerInterface;
use App\Models\Architecture\TypeEmplacement as Type;
use Illuminate\Http\Request;

class TypeEmplacementsController extends Controller implements StandardControllerInterface
{
    public function all()
    {
        $types = Type::with('site')->get();
        return response()->json(['types' => $types]);
    }

    public function store(Request $request)
    {
        $request->validate(Type::RULES);
        $type = new Type($request->all());
        $type->code = (int) Type::get()->count() + 1;
        $type->save();
        $message = "Le type d'emplacement $request->nom a été crée avec succès.";
        return response()->json(['message' => $message, 'id' => $type->id]);
    }

    public function update(int $id, Request $request)
    {
        $request->validate(Type::RULES);
        $type = Type::find($id);
        $type->update($request->all());
        $message = "Le type d'emplacement $request->nom a été modifié avec succès.";
        return response()->json(['message' => $message]);
    }

    public function push(Request $request)
    {
        $request->validate(Type::RULES);
        $type = new Type($request->all());
        $type->save();
        $message = "Le type d'emplacement $request->nom a été crée avec succès.";
        $freshMarche = $type->fresh();
        return response()->json(['message' => $message, 'marche' => $freshMarche]);
    }

    public function trash(int $id)
    {
        $type = Type::find($id);
        $type->delete();
        $message = "Le type d'emplacement $type->nom a été supprimé avec succès.";
        return response()->json(['message' => $message]);
    }

    public function restore(int $id)
    {
        $type = Type::withTrashed()->find($id);
        $type->restore();
        $message = "Le type d'emplacement $type->nom a été restauré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trashed()
    {
        $types = Type::with('site')->onlyTrashed()->get();
        return response()->json(['types' => $types]);
    }

    public function show(int $id)
    {
        $type = Type::withTrashed()->find($id);
        return response()->json(['type' => $type]);
    }
}
