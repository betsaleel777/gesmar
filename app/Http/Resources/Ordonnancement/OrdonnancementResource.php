<?php

namespace App\Http\Resources\Ordonnancement;

use App\Http\Resources\Contrat\ContratResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdonnancementResource extends JsonResource
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
            'created_at' => $this->created_at,
            'status' => $this->whenAppended('status'),
            'contrat' => ContratResource::make($this->whenLoaded('contrat')),
            'paiements' => PaiementResource::collection($this->whenLoaded('paiements')),
        ];
    }
}
