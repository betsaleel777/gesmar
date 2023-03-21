<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Interfaces\StandardControllerInterface;
use App\Models\Architecture\Niveau;
use App\Models\Architecture\Pavillon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NiveauxController extends Controller implements StandardControllerInterface
{
    /**
     * Undocumented function
     *
     * @param  int  $nombre
     * @return void
     */
    private static function pusher(int $pavillon, int $nombre): void
    {
        $start = (int) Pavillon::with('niveaux')->findOrFail($pavillon)->niveaux->count();
        $fin = $start + $nombre;
        while ($start < $fin) {
            $start++;
            $niveau = new Niveau();
            $niveau->pavillon_id = $pavillon;
            $niveau->nom = 'niveau ' . $start;
            $niveau->code = (string) $start;
            $niveau->save();
        }
    }

    public function all(): JsonResponse
    {
        $niveaux = Niveau::with('pavillon.site')->get();
        return response()->json(['niveaux' => $niveaux]);
    }

    public function store(Request $request): JsonResponse
    {
        if ($request->automatiq) {
            $request->validate(Niveau::MIDDLE_RULES);
            self::pusher($request->pavillon_id, $request->nombre);
        } else {
            $request->validate(Niveau::RULES);
            $niveau = new Niveau($request->all());
            $pavillon = Pavillon::with('niveaux')->findOrFail((int)$request->pavillon_id);
            $niveau->code = (string) ($pavillon->niveaux->count() + 1);
            $niveau->save();
        }
        $message = "Le niveau $request->nom a été crée avec succès.";

        return response()->json(['message' => $message]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $request->validate(Niveau::RULES);
        $niveau = Niveau::findOrFail($id);
        $niveau->nom = $request->nom;
        $niveau->pavillon_id = $request->pavillon_id;
        $niveau->save();
        $message = 'Le niveau a été modifié avec succès.';
        return response()->json(['message' => $message]);
    }

    public function trash(int $id): JsonResponse
    {
        $niveau = Niveau::findOrFail($id);
        $niveau->delete();
        $message = "Le niveau $niveau->nom a été supprimé avec succès.";
        return response()->json(['message' => $message]);
    }

    public function restore(int $id): JsonResponse
    {
        $niveau = Niveau::withTrashed()->find($id);
        $niveau->restore();
        $message = "Le niveau $niveau->nom a été restauré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trashed(): JsonResponse
    {
        $niveaux = Niveau::with('pavillon')->onlyTrashed()->get();
        return response()->json(['niveaux' => $niveaux]);
    }

    public function show(int $id): JsonResponse
    {
        $niveau = Niveau::withTrashed()->find($id);
        return response()->json(['niveau' => $niveau]);
    }

    public function getByPavillon(int $id): JsonResponse
    {
        $niveaux = Pavillon::findOrFail($id)->niveaux;
        return response()->json(['niveaux' => $niveaux]);
    }
}
