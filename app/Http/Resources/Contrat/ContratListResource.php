<?php

namespace App\Http\Resources\Contrat;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
            'code' => $this->code_contrat ?? $this->code,
            'created_at' => $this->created_at->format('d-m-Y'),
            'status' => $this->whenAppended('status'),
            'emplacement' => $this->whenLoaded('emplacement', fn() => $this->emplacement->code),
            'annexe' => $this->whenLoaded('annexe', fn() => $this->annexe->code),
            'personne' => $this->whenLoaded('personne', fn() => Str::lower($this->personne->getAlias())),
            'equipements' => EquipementResource::collection($this->whenLoaded('equipements')),
        ];
    }
}
