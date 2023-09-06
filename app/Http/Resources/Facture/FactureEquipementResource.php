<?php

namespace App\Http\Resources\Facture;

use App\Http\Resources\Abonnement\EquipementResource;
use App\Http\Resources\Contrat\ContratResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FactureEquipementResource extends JsonResource
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
            'index_depart' => $this->index_depart,
            'index_fin' => $this->index_fin,
            'status' => $this->whenAppended('status'),
            'contrat' => ContratResource::make($this->whenLoaded('contrat')),
            'equipement' => EquipementResource::make($this->whenLoaded('equipement')),
        ];
    }
}
