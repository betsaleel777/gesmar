<?php

namespace App\Http\Resources\Ordonnancement;

use Illuminate\Http\Resources\Json\JsonResource;

class OrdonnancementListeResource extends JsonResource
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
            'total' => $this->total,
            'code' => $this->code,
            'status' => $this->whenAppended('status'),
            'created_at' => $this->created_at->format('d-m-Y'),
            'personne' => $this->when(
                $this->relationLoaded('contrat') and $this->contrat->relationLoaded('personne'),
                fn() => $this->contrat->personne->getAlias()
            ),
            'emplacement' => $this->when(
                $this->relationLoaded('contrat') and $this->contrat->relationLoaded('emplacement'),
                fn() => $this->contrat->emplacement?->code
            ),
            'annexe' => $this->when(
                $this->relationLoaded('contrat') and $this->contrat->relationLoaded('annexe'),
                fn() => $this->contrat->annexe?->code
            ),
        ];
    }
}
