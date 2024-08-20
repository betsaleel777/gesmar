<?php

namespace App\Http\Resources\Ordonnancement;

use App\Http\Resources\Contrat\ContratResource;
use App\Http\Resources\Emplacement\EmplacementResource;
use App\Http\Resources\Personne\PersonneResource;
use App\Http\Resources\ServiceAnnexeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdonnancementListeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'total' => $this->total,
            'code' => $this->code,
            'status' => $this->whenAppended('status'),
            'created_at' => $this->created_at->format('d-m-Y'),
            'personne' => PersonneResource::make($this->whenLoaded('personne')),
            'annexe' => ServiceAnnexeResource::make($this->whenLoaded('annexe')),
            'emplacement' => EmplacementResource::make($this->whenLoaded('emplacement')),
            'contrat' => ContratResource::make($this->whenLoaded('contrat')),
        ];
    }
}
