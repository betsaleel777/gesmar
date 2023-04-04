<?php

namespace App\Http\Resources\Abonnement;

use App\Http\Resources\SiteResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TypeEquipementResource extends JsonResource
{
    public static $wrap = "type";
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
            'site_id' => $this->site_id,
            'frais_penalite' => $this->frais_penalite,
            'caution_abonnement' => $this->caution_abonnement,
            'site' => SiteResource::make($this->whenLoaded('site')),
        ];
    }
}
