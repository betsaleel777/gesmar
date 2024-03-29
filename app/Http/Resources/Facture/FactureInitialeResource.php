<?php

namespace App\Http\Resources\Facture;

use App\Http\Resources\Contrat\ContratResource;
use App\Http\Resources\Ordonnancement\PaiementResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FactureInitialeResource extends JsonResource
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
            'avance' => $this->avance,
            'caution' => $this->caution,
            'pas_porte' => $this->pas_porte,
            'sommeVersee' => $this->sommeVersee ?? 0,
            'status' => $this->whenAppended('status'),
            'contrat' => ContratResource::make($this->whenLoaded('contrat')),
            'paiements' => PaiementResource::collection($this->whenLoaded('paiements')),
        ];
    }
}
