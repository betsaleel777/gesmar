<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Interfaces\StandardControllerInterface;
use App\Models\Architecture\Pavillon;
use App\Models\Architecture\Site;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PavillonsController extends Controller implements StandardControllerInterface
{
    private static function pusher(int $site, int $nombre): void
    {
        $start = (int) Site::findOrFail($site)->pavillons->count();
        $fin = $start + $nombre;
        while ($start < $fin) {
            $start++;
            $pavillon = new Pavillon();
            $pavillon->site_id = $site;
            $pavillon->nom = 'pavillon '.$start;
            $pavillon->code = (string) $start;
            $pavillon->save();
        }
    }

    public function all(): JsonResponse
    {
        $pavillons = Pavillon::with('site')->get();

        return response()->json(['pavillons' => $pavillons]);
    }

    public function store(Request $request): JsonResponse
    {
        if ($request->automatiq) {
            $request->validate(Pavillon::MIDDLE_RULES);
            self::pusher($request->site_id, $request->nombre);
        } else {
            $request->validate(Pavillon::RULES);
            $pavillon = new Pavillon($request->all());
            $pavillon->code = (string) (Site::with('pavillons')->findOrFail($request->site_id)->pavillons->count() + 1);
            $pavillon->save();
        }
        $message = "Le pavillon $request->nom a été crée avec succès.";

        return response()->json(['message' => $message]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $request->validate(Pavillon::RULES);
        $pavillon = Pavillon::findOrFail($id);
        $pavillon->nom = $request->nom;
        $pavillon->site_id = $request->site_id;
        $pavillon->save();
        $message = 'Le pavillon a été modifié crée avec succès.';

        return response()->json(['message' => $message]);
    }

    public function push(Request $request): JsonResponse
    {
        $request->validate(Pavillon::PUSH_RULES);
        self::pusher($request->id, $request->nombre);
        $message = "$request->nombre pavillons ont été crée avec succès.";
        $pavillons = Site::findOrFail($request->id)->pavillons;

        return response()->json(['message' => $message, 'pavillons' => $pavillons]);
    }

    public function trash(int $id): JsonResponse
    {
        $pavillon = Pavillon::findOrFail($id);
        $pavillon->delete();
        $message = "Le pavillon $pavillon->nom a été supprimé avec succès.";

        return response()->json(['message' => $message]);
    }

    public function restore(int $id): JsonResponse
    {
        $pavillon = Pavillon::withTrashed()->find($id);
        $pavillon->restore();
        $message = "Le pavillon $pavillon->nom a été restauré avec succès.";

        return response()->json(['message' => $message]);
    }

    public function trashed(): JsonResponse
    {
        $pavillons = Pavillon::with('site')->onlyTrashed()->get();

        return response()->json(['pavillons' => $pavillons]);
    }

    public function show(int $id): JsonResponse
    {
        $pavillon = Pavillon::withTrashed()->find($id);

        return response()->json(['pavillon' => $pavillon]);
    }

    public function getByMarche(int $id): JsonResponse
    {
        $pavillons = Site::findOrFail($id)->pavillons;

        return response()->json(['pavillons' => $pavillons]);
    }
}
