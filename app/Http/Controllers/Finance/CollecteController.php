<?php

namespace App\Http\Controllers\Finance;

use App\Events\CollecteRegistred;
use App\Http\Controllers\Controller;
use App\Models\Finance\Attribution;
use App\Models\Finance\Collecte;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CollecteController extends Controller
{
    public function all(): JsonResponse
    {
        $attributions = Collecte::with('attribution')->get();
        return response()->json(['attributions' => $attributions]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(Collecte::RULES);
        $collecte = new Collecte($request->all());
        $message = "La somme a bien été collectée";
        if ($collecte->nombre > 1) {
            $attribution = Attribution::findOrFail($request->attribution_id);
            $attribution->collecter();
            $start = (new Carbon($attribution->jour))->addDay()->format('Y-m-d');
            $fin = (new Carbon($attribution->jour))->addDays($request->nombre - 1)->format('Y-m-d');
            $period = CarbonPeriod::create($start, $fin);
            foreach ($period as $date) {
                $futurAttribution = new Attribution([
                    'commercial_id' => $attribution->commercial_id,
                    'emplacement_id' => $attribution->emplacement_id,
                    'jour' => $date->format('Y-m-d'),
                    'bordereau_id' => $attribution->bordereau_id,
                ]);
                $futurAttribution->save();
                $futurAttribution->encaisser();
            }
        }
        $collecte->save();
        CollecteRegistred::dispatch($collecte);
        return response()->json(['message' => $message]);
    }
}
