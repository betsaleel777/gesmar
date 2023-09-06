<?php

namespace App\Http\Resources\Facture;

use App\Http\Resources\Contrat\ContratResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FactureResource extends JsonResource
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
            'contrat' => ContratResource::make($this->whenLoaded('contrat')),
        ];
    }
}
