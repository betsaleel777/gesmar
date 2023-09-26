<?php

namespace App\Http\Resources\Facture;

use Illuminate\Http\Resources\Json\JsonResource;

class FactureLoyerListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'status' => $this->whenAppended('status'),
            'contrat' => $this->whenLoaded('contrat', fn () => $this->contrat->code_contrat ?? $this->contrat->code),
            'personne' => $this->when(
                $this->relationLoaded('contrat') and $this->contrat->relationLoaded('personne'),
                $this->contrat->personne->nom . ' ' . $this->contrat->personne->prenom
            ),
            'emplacement' => $this->when(
                $this->relationLoaded('contrat') and $this->contrat->relationLoaded('emplacement'),
                $this->contrat->emplacement->code
            ),
            'loyer' => $this->when(
                $this->relationLoaded('contrat') and $this->contrat->relationLoaded('emplacement'),
                $this->contrat->emplacement->loyer
            ),
        ];
    }
}
