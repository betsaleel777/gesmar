<?php

namespace App\Http\Resources\Abonnement;

use App\Http\Resources\SiteResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TypeEquipementListResource extends JsonResource
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
            'nom' => $this->nom,
            'frais_penalite' => $this->frais_penalite,
            'caution_abonnement' => $this->caution_abonnement,
            'created_at' => $this->whenNotNull($this->created_at?->format('d-m-Y')),
            'site_id' => $this->whenNotNull($this->site_id),
            'site' => SiteResource::make($this->whenLoaded('site')),
        ];
    }
}
