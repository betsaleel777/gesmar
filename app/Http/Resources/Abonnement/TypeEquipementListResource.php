<?php

namespace App\Http\Resources\Abonnement;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
            'created_at' => $this->created_at->format('d-m-Y'),
            'site_id' => $this->whenLoaded('site', fn () => $this->site->id),
            'site' => $this->whenLoaded('site', fn () => Str::lower($this->site->nom)),
        ];
    }
}
