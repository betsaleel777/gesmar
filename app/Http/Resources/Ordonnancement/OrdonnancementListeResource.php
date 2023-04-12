<?php

namespace App\Http\Resources\Ordonnancement;

use Illuminate\Http\Resources\Json\JsonResource;

class OrdonnancementListeResource extends JsonResource
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
            'total' => $this->total,
            'code' => $this->code,
            'status' => $this->whenAppended('status'),
            'created_at' => $this->created_at,
            'personne' => $this->when(
                $this->relationLoaded('contrat') and $this->contrat->relationLoaded('personne'),
                fn () => $this->contrat->personne->alias
            ),
            'emplacement' => $this->when(
                $this->relationLoaded('contrat') and $this->contrat->relationLoaded('emplacement'),
                fn () => $this->contrat->emplacement?->code
            ),
            'annexe' => $this->when(
                $this->relationLoaded('contrat') and $this->contrat->relationLoaded('annexe'),
                fn () => $this->contrat->annexe?->code
            ),
        ];
    }
}
