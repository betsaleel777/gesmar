<?php

namespace App\Http\Resources\Contrat;

use Illuminate\Http\Resources\Json\JsonResource;

class ContratSelectResource extends JsonResource
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
            'code' => $this->codification(),
            'texte' => match (true) {
                !empty($this->annexe) and $this->relationLoaded('personne') => $this->codification() . '-' . $this->annexe->code . '-' . $this->personne->getAlias(),
                !empty($this->emplacement) and $this->relationLoaded('personne') => $this->codification() . '-' . $this->emplacement->code . '-' . $this->personne->getAlias()
            },
        ];
    }
}
