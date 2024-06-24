<?php

namespace App\Http\Resources\Abonnement;

use App\Http\Resources\Emplacement\EmplacementResource;
use App\Http\Resources\SiteResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Architecture\Abonnement;

/**
 * @property Abonnement $resource
 */
class AbonnementResource extends JsonResource
{
    public static $wrap = "abonnement";
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->whenNotNull($this->code),
            'equipement_id' => $this->whenNotNull($this->equipement_id),
            'emplacement_id' => $this->whenNotNull($this->emplacement_id),
            'site_id' => $this->whenNotNull($this->site_id),
            'index_autre' => $this->whenNotNull($this->index_autre),
            'index_depart' => $this->whenNotNull($this->index_depart),
            'index_fin' => $this->whenNotNull($this->index_fin),
            'prix_unitaire' => $this->whenNotNull($this->prix_unitaire),
            'prix_fixe' => $this->whenNotNull($this->prix_fixe),
            'frais_facture' => $this->whenNotNull($this->frais_facture),
            'status' => $this->whenAppended('status'),
            'site' => SiteResource::make($this->whenLoaded('site')),
            'emplacement' => EmplacementResource::make($this->whenLoaded('emplacement')),
            'equipement' => EquipementResource::make($this->whenLoaded('equipement')),
        ];
    }
}
