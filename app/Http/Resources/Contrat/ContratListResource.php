<?php

namespace App\Http\Resources\Contrat;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Exploitation\Contrat;
use Illuminate\Support\Str;

/**
 * @property Contrat $resource
 */
class ContratListResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code_contrat ?? $this->code,
            'created_at' => $this->created_at?->format('d-m-Y'),
            'date_signature' => $this->whenNotNull($this->date_signature?->format('d-m-Y')),
            'status' => $this->whenAppended('status'),
            'uptodate' => $this->whenNotNull($this->getStatus()),
            'emplacement' => $this->whenLoaded('emplacement', fn() => $this->emplacement->code),
            'annexe' => $this->whenLoaded('annexe', fn() => $this->annexe->code),
            'personne' => $this->whenLoaded('personne', fn() => Str::lower($this->personne->getFullname())),
            'equipements' => EquipementResource::collection($this->whenLoaded('equipements')),
        ];
    }
}
