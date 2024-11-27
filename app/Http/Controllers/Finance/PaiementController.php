<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Resources\Facture\FactureInitialeResource;
use App\Http\Resources\Paiement\PaiementEquipementResource;
use App\Http\Resources\Paiement\PaiementInitialResource;
use App\Http\Resources\Paiement\PaiementLoyerResource;
use App\Models\Exploitation\Paiement;
use App\Models\Finance\Facture;
use App\Repositories\RelevePaiementRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaiementController extends Controller
{

    public function __construct(private RelevePaiementRepository $releve) {}

    public function getReleve(Request $request): JsonResponse
    {
        ['initiales' => $initiales, 'facture' => $facture] = $this->releve->getInitials($request);
        return response()->json([
            'initiales' => $initiales,
            'factureInitiale' => $facture,
            'loyers' => $this->releve->getRents($request),
            'equipements' => $this->releve->getGears($request)
        ]);
    }
}
