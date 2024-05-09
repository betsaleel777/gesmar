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
            'code' => $this->whenNotNull($this->code),
            'avance' => $this->whenNotNull($this->avance),
            'caution' => $this->whenNotNull($this->caution),
            'pas_porte' => $this->whenNotNull($this->pas_porte),
            'frais_dossier' => $this->whenNotNull($this->frais_dossier),
            'frais_amenagement' => $this->whenNotNull($this->frais_amenagement),
            'sommeVersee' => $this->sommeVersee ?? 0,
            'status' => $this->whenAppended('status'),
            'contrat' => ContratResource::make($this->whenLoaded('contrat')),
            'paiements' => PaiementResource::collection($this->whenLoaded('paiements')),
        ];
    }
}
