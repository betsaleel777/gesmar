<?php

namespace App\Http\Resources\Emplacement;

use App\Http\Resources\Abonnement\AbonnementResource;
use App\Http\Resources\Contrat\ContratResource;
use App\Http\Resources\Personne\PersonneResource;
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
            'site_id' => $this->whenLoaded('site', fn () => $this->site->id),
            'type' => TypeEmplacementResource::make($this->whenLoaded('type')),
            'zone' => ZoneResource::make($this->whenLoaded('zone')),
            'abonnements' => AbonnementResource::collection($this->whenLoaded('abonnements')),
            'personne' => $this->when(
                $this->relationLoaded('contratActuel') and $this->contratActuel->relationLoaded('personne'),
                fn () => PersonneResource::make($this->contratActuel->personne)
            ),
        ];
    }
}
