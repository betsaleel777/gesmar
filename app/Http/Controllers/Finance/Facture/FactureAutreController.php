<?php

namespace App\Http\Controllers\Finance\Facture;

use App\Http\Controllers\Controller;
use App\Interfaces\AutreFactureInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FactureAutreController extends Controller
{
    public function __construct(protected AutreFactureInterface $factureRepository) {}

    public function all(Request $request): JsonResource
    {
        return $this->factureRepository->all($request);
    }

    public function show(Request $request): JsonResource
    {
        return $this->factureRepository->show($request);
    }

    public function getPaginate(Request $request): JsonResource
    {
        return $this->factureRepository->getPaginate($request);
    }

    public function getSearch(Request $request): JsonResource
    {
        return $this->factureRepository->getSearch($request);
    }
}
