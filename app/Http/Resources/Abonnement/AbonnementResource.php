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
            'code' => $this->code,
            'equipement_id' => $this->equipement_id,
            'emplacement_id' => $this->emplacement_id,
            'site_id' => $this->site_id,
            'index_autre' => $this->index_autre,
            'index_depart' => $this->index_depart,
            'index_fin' => $this->index_fin,
            'status' => $this->whenAppended('status'),
            'site' => SiteResource::make($this->whenLoaded('site')),
            'emplacement' => EmplacementResource::make($this->whenLoaded('emplacement')),
            'equipement' => EquipementResource::make($this->whenLoaded('equipement')),
        ];
    }
}
