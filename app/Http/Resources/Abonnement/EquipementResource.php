<?php

namespace App\Http\Resources\Abonnement;

use App\Http\Resources\Emplacement\EmplacementResource;
use App\Http\Resources\SiteResource;
use App\Models\Architecture\Equipement;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Equipement $resource
 */
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
            'code' => $this->whenNotNull($this->code),
            'nom' => $this->when(!empty($this->nom), str($this->nom)->lower()),
            'alias' => $this->whenLoaded('type', fn () => $this->code . ' ' . $this->type->nom),
            'prix_unitaire' => $this->whenNotNull($this->prix_unitaire),
            'prix_fixe' => $this->whenNotNull($this->prix_fixe),
            'frais_facture' => $this->whenNotNull($this->frais_facture),
            'index' => $this->whenNotNull($this->index),
            'type_equipement_id' => $this->whenNotNull($this->type_equipement_id),
            'emplacement_id' => $this->whenNotNull($this->emplacement_id),
            'site_id' => $this->whenNotNull($this->site_id),
            'abonnement' => $this->whenNotNull($this->abonnement),
            'abonnementActuel' => AbonnementResource::make($this->whenLoaded('abonnementActuel')),
            'abonnements' => AbonnementResource::collection($this->whenLoaded('abonnements')),
            'emplacement' => EmplacementResource::make($this->whenLoaded('emplacement')),
            'site' => SiteResource::make($this->whenLoaded('site')),
            'type' => TypeEquipementResource::make($this->whenLoaded('type')),
        ];
    }
}
