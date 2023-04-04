<?php

namespace App\Http\Resources\Abonnement;

use App\Http\Resources\Emplacement\EmplacementResource;
use App\Http\Resources\SiteResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipementResource extends JsonResource
{
    public static $wrap = "equipement";
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'code' => $this->code,
            'prix_unitaire' => $this->prix_unitaire,
            'prix_fixe' => $this->prix_fixe,
            'frais_facture' => $this->frais_facture,
            'index' => $this->index,
            'type_equipement_id' => $this->type_equipement_id,
            'emplacement_id' => $this->emplacement_id,
            'site_id' => $this->site_id,
            'emplacement' => EmplacementResource::make($this->whenLoaded('emplacement')),
            'site' => SiteResource::make($this->whenLoaded('site')),
            'type' => TypeEquipementResource::make($this->whenLoaded('type')),
        ];
    }
}
