<?php

namespace App\Http\Resources\Emplacement;

use App\Http\Resources\Abonnement\AbonnementResource;
use App\Http\Resources\Abonnement\EquipementResource;
use App\Http\Resources\Contrat\ContratResource;
use App\Http\Resources\Personne\PersonneResource;
use App\Http\Resources\SiteResource;
use App\Models\Architecture\Emplacement;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Emplacement $resource
 */
class EmplacementResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->whenNotNull($this->code),
            'nom' => $this->when(!empty($this->nom), str($this->nom)->lower()),
            'superficie' => $this->whenNotNull($this->superficie),
            'loyer' => $this->whenNotNull($this->loyer),
            'pas_porte' => $this->whenNotNull($this->pas_porte),
            'caution' => $this->whenNotNull($this->caution),
            'zone_id' => $this->whenNotNull($this->zone_id),
            'type_emplacement_id' => $this->whenNotNull($this->type_emplacement_id),
            'site' => SiteResource::make($this->whenLoaded('site')),
            'type' => TypeEmplacementResource::make($this->whenLoaded('type')),
            'zone' => ZoneResource::make($this->whenLoaded('zone')),
            'abonnements' => AbonnementResource::collection($this->whenLoaded('abonnements')),
            'abonnementsActuels' => AbonnementResource::collection($this->whenLoaded('abonnementsActuels')),
            'personne' => $this->when(
                $this->relationLoaded('contratActuel') and $this->contratActuel->relationLoaded('personne'),
                fn () => PersonneResource::make($this->contratActuel->personne)
            ),
            'equipements' => EquipementResource::collection($this->whenLoaded('equipements')),
            'contrat' => ContratResource::make($this->whenLoaded('contratActuel')),
        ];
    }
}
