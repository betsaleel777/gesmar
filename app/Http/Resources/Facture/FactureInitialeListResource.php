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
            'avance' => $this->whenNull($this->avance, 0),
            'caution' => $this->whenNull($this->caution, 0),
            'pas_porte' => $this->pas_porte,
            'status' => $this->whenAppended('status'),
            'contrat' => $this->whenLoaded('contrat', fn () => $this->contrat->code_contrat ?? $this->contrat->code),
            'personne' => $this->when(
                $this->relationLoaded('contrat') and $this->contrat->relationLoaded('personne'),
                $this->contrat->personne->nom . ' ' . $this->contrat->personne->prenom
            ),
            'emplacement' => $this->when(
                $this->relationLoaded('contrat') and $this->contrat->relationLoaded('emplacement'),
                fn () => $this->contrat->emplacement->code
            ),
        ];
    }
}
