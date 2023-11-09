<?php

namespace App\Http\Resources\Abonnement;

use App\Http\Resources\SiteResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipementListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->when(!empty($this->nom), str($this->nom)->lower()),
            'code' => $this->whenNotNull($this->code),
            'site_id' => $this->whenNotNull($this->site_id),
            'prix_unitaire' => $this->whenNotNull($this->prix_unitaire),
            'prix_fixe' => $this->whenNotNull($this->prix_fixe),
            'abonnement' => $this->whenNotNull($this->abonnement),
            'liaison' => $this->whenNotNull($this->liaison),
            'created_at' => $this->whenNotNull($this->created_at?->format('d-m-Y')),
            'site' => SiteResource::make($this->whenLoaded('site')),
            'type' => TypeEquipementResource::make($this->whenLoaded('type')),
        ];
    }
}
