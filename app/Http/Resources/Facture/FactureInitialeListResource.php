<?php

namespace App\Http\Resources\Facture;

use Illuminate\Http\Resources\Json\JsonResource;

class FactureInitialeListResource extends JsonResource
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
            'status' => $this->whenAppended('status'),
            'contrat' => $this->whenLoaded('contrat', fn () => $this->contrat->code),
            'personne' => $this->when(
                $this->relationLoaded('contrat') and $this->contrat->relationLoaded('personne'),
                fn () => $this->contrat->personne->alias
            ),
            'emplacement' => $this->when(
                $this->relationLoaded('contrat') and $this->contrat->relationLoaded('emplacement'),
                fn () => $this->contrat->emplacement->code
            ),
        ];
    }
}
