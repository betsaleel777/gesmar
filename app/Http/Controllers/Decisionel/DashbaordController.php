<?php

namespace App\Http\Controllers\Decisionel;

use App\Http\Controllers\Controller;
use App\Models\Architecture\Emplacement;
use App\Models\Architecture\Equipement;
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
        $emplacementsEquipes = Emplacement::isLinked()->count();
        $emplacementsSansEquipement = Emplacement::isUnlinked()->count();
        $emplacementsAbonnes = Emplacement::has('abonnementsActuels')->count();
        $emplacementsNonAbonnes = Emplacement::doesntHave('abonnementsActuels')->count();
        $equipementsLibres = Equipement::unlinked()->count();
        $equipementsLies = Equipement::linked()->count();
        return response()->json([
            'demandesEnCours' => $demandesEnCours,
            'demandesValidees' => $demandesValidees,
            'prospects' => $prospects,
            'clients' => $clients,
            'emplacementsDisponibles' => $emplacementsDisponibles,
            'emplacementsOccupes' => $emplacementsOccupes,
            'emplacementsEquipes' => $emplacementsEquipes,
            'emplacementsSansEquipement' => $emplacementsSansEquipement,
            'emplacementsAbonnes' => $emplacementsAbonnes,
            'emplacementsNonAbonnes' => $emplacementsNonAbonnes,
            'equipementsLies' => $equipementsLies,
            'equipementsLibres' => $equipementsLibres,
        ]);
    }
}
