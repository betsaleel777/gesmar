<?php

namespace App\Http\Resources\Facture;

use App\Http\Resources\Contrat\ContratResource;
use App\Http\Resources\Ordonnancement\PaiementResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FactureAnnexeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'contrat_code' => $this->whenLoaded('contrat', fn() => $this->contrat->code),
            'contrat' => ContratResource::make($this->whenLoaded('contrat')),
            'paiements' => PaiementResource::collection($this->whenLoaded('paiements')),
        ];
    }
}
