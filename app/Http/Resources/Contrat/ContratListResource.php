<?php

namespace App\Http\Resources\Contrat;

use Illuminate\Http\Resources\Json\JsonResource;

class ContratListResource extends JsonResource
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
            'created_at' => $this->created_at,
            'status' => $this->whenAppended('status'),
            'emplacement' => $this->whenLoaded('emplacement', fn () => $this->emplacement->code),
            'annexe' => $this->whenLoaded('annexe', fn () => $this->annexe->code),
            'personne' => $this->whenLoaded('personne', fn () => $this->personne->alias),
            'equipements' => EquipementResource::collection($this->whenLoaded('equipements')),
        ];
    }
}
