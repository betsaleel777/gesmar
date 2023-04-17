<?php

namespace App\Http\Resources\Caisse;

use Illuminate\Http\Resources\Json\JsonResource;

class EspeceResource extends JsonResource
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
            'montant' => $this->montant,
            'versement' => $this->versement,
        ];
    }
}
