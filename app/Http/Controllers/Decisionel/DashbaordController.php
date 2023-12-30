<?php

namespace App\Http\Controllers\Decisionel;

use App\Http\Controllers\Controller;
use App\Models\Architecture\Emplacement;
use App\Models\Exploitation\Contrat;
use App\Models\Exploitation\Personne;
use Illuminate\Http\JsonResponse;

class DashbaordController extends Controller
{
    public function reception(): JsonResponse
    {
        $demandesEnCours = Contrat::inProcess()->count();
        $demandesValidees = Contrat::validated()->count();
        $prospects = Personne::isProspect()->count();
        $clients = Personne::isClient()->count();
        $emplacementsDisponibles = Emplacement::isFree()->count();
        $emplacementsOccupes = Emplacement::isBusy()->count();
        $emplacementsLies = Emplacement::isLinked()->count();
        return response()->json([
            'demandesEnCours' => $demandesEnCours,
            'demandesValidees' => $demandesValidees,
            'prospects' => $prospects,
            'clients' => $clients,
            'emplacementsDisponibles' => $emplacementsDisponibles,
            'emplacementsOccupes' => $emplacementsOccupes,
            'emplacementsLies' => $emplacementsLies,
        ]);
    }
}
