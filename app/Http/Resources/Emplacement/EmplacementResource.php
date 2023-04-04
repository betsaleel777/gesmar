<?php

namespace App\Http\Resources\Emplacement;

use App\Http\Resources\Abonnement\AbonnementResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EmplacementResource extends JsonResource
{
    public static $wrap = "emplacement";
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
            'nom' => $this->nom,
            'superficie' => $this->superficie,
            'loyer' => $this->loyer,
            'pas_porte' => $this->pas_porte,
            'caution' => $this->caution,
            'zone_id' => $this->zone_id,
            'type_emplacement_id' => $this->type_emplacement_id,
            'type' => TypeEmplacementResource::make($this->whenLoaded('type')),
            'zone' => ZoneResource::make($this->whenLoaded('zone')),
            'abonnements' => AbonnementResource::collection($this->whenLoaded('abonnements')),
        ];
    }
}
