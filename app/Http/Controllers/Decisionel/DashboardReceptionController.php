<?php

namespace App\Http\Controllers\Decisionel;

use App\Enums\StatusEmplacement;
use App\Enums\StatusEquipement;
use App\Http\Controllers\Controller;
use App\Models\Architecture\Emplacement;
use App\Models\Architecture\Equipement;
use App\Models\Exploitation\Contrat;
use App\Models\Exploitation\Personne;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardReceptionController extends Controller
{
    public function demandeValidationRate(Request $request): JsonResponse
    {
        $demandesEnCours = Contrat::inProcess()->filterBetweenStatusDate($request->query('dates'))->count();
        $demandesValidees = Contrat::validated()->filterBetweenStatusDate($request->query('dates'))->count();
        return response()->json(['demandesEnCours' => $demandesEnCours, 'demandesValidees' => $demandesValidees]);
    }

    public function personneConversionRate(Request $request): JsonResponse
    {
        $prospects = Personne::isProspect()->filterBetweenStatusDate($request->query('dates'))->count();
        $clients = Personne::isClient()->filterBetweenStatusDate($request->query('dates'))->count();
        return response()->json(['prospects' => $prospects, 'clients' => $clients]);
    }

    public function emplacementBusyRate(Request $request): JsonResponse
    {
        $emplacementsDisponibles = Emplacement::isFree()->filterBetweenDisponibilityDate($request->query('dates'))->count();
        $emplacementsOccupes = Emplacement::isBusy()->filterBetweenDisponibilityDate($request->query('dates'), StatusEmplacement::BUSY->value)->count();
        return response()->json([
            'emplacementsDisponibles' => $emplacementsDisponibles,
            'emplacementsOccupes' => $emplacementsOccupes,
        ]);
    }

    public function emplacementEquippedRate(Request $request): JsonResponse
    {
        $emplacementsEquipes = Emplacement::isLinked()->filterBetweenLiaisonDate($request->query('dates'))->count();
        $emplacementsSansEquipement = Emplacement::isUnlinked()->filterBetweenLiaisonDate($request->query('dates'), StatusEmplacement::UNLINKED->value)->count();
        return response()->json([
            'emplacementsEquipes' => $emplacementsEquipes,
            'emplacementsSansEquipement' => $emplacementsSansEquipement,
        ]);
    }

    public function equipementLinkedRate(Request $request): JsonResponse
    {
        $equipementsLies = Equipement::linked()->filterBetweenLiaisonDate($request->query('dates'))->count();
        $equipementsLibres = Equipement::unlinked()->filterBetweenLiaisonDate($request->query('dates'), StatusEquipement::UNLINKED->value)->count();
        return response()->json([
            'equipementsLies' => $equipementsLies,
            'equipementsLibres' => $equipementsLibres,
        ]);
    }

    public function emplacementSubscribedRate(Request $request): JsonResponse
    {
        $emplacementsAbonnes = Emplacement::has('abonnementsActuels')->filterBetweenSubscribeDate($request->query('dates'))->count();
        $emplacementsNonAbonnes = Emplacement::doesntHave('abonnementsActuels')->filterBetweenSubscribeDate($request->query('dates'), false)->count();
        return response()->json([
            'emplacementsAbonnes' => $emplacementsAbonnes,
            'emplacementsNonAbonnes' => $emplacementsNonAbonnes,
        ]);
    }
}
