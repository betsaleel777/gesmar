<?php

namespace App\Http\Resources\Facture;

use Illuminate\Http\Resources\Json\JsonResource;

class FactureAnnexeListResource extends JsonResource
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
            'status' => $this->whenAppended('status'),
            'contrat_code' => $this->whenLoaded('contrat', fn () => $this->contrat->code),
            'personne' => $this->when(
                $this->relationLoaded('contrat') and $this->contrat->relationLoaded('personne'),
                fn () => $this->contrat->personne->alias
            ),
            'annexe' => $this->whenLoaded('annexe', fn () => $this->annexe->nom),
            'prix' => $this->whenLoaded('annexe', fn () => $this->annexe->prix),
        ];
    }
}
