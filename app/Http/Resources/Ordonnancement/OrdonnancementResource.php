<?php

namespace App\Http\Resources\Ordonnancement;

use App\Http\Resources\Contrat\ContratResource;
use App\Http\Resources\Emplacement\EmplacementResource;
use App\Http\Resources\Personne\PersonneResource;
use App\Http\Resources\ServiceAnnexeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdonnancementResource extends JsonResource
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
            'total' => $this->whenNotNull($this->total, 0),
            'code' => $this->whenNotNull($this->code),
            'created_at' => $this->whenNotNull($this->created_at),
            'status' => $this->whenAppended('status'),
            'contrat' => ContratResource::make($this->whenLoaded('contrat')),
            'paiements' => PaiementResource::collection($this->whenLoaded('paiements')),
            'emplacement' => EmplacementResource::make($this->whenLoaded('emplacement')),
            'annexe' => ServiceAnnexeResource::make($this->whenLoaded('annexe')),
            'personne' => PersonneResource::make($this->whenLoaded('personne')),
        ];
    }
}
