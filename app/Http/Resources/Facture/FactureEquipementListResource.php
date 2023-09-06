<?php

namespace App\Http\Resources\Facture;

use Illuminate\Http\Resources\Json\JsonResource;

class FactureEquipementListResource extends JsonResource
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
            'index_depart' => $this->index_depart,
            'index_fin' => $this->index_fin,
            'status' => $this->whenAppended('status'),
            'contrat_code' => $this->whenLoaded('contrat', fn () => $this->contrat->code),
            'personne' => $this->when(
                $this->relationLoaded('contrat') and $this->contrat->relationLoaded('personne'),
                fn () => $this->contrat->personne->alias
            ),
            'emplacement' => $this->when(
                $this->relationLoaded('contrat') and $this->contrat->relationLoaded('emplacement'),
                fn () => $this->contrat->emplacement->code
            ),
            'loyer' => $this->when(
                $this->relationLoaded('contrat') and $this->contrat->relationLoaded('emplacement'),
                fn () => $this->contrat->emplacement->loyer
            ),
        ];
    }
}
