<?php

namespace App\Http\Resources\Bordereau;

use Illuminate\Http\Resources\Json\JsonResource;

class CollecteResource extends JsonResource
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
            'nombre' => $this->nombre,
            'montant' => $this->montant,
            'attribution_id' => $this->attribution_id,
        ];
    }
}
