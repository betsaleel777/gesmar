<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SocieteResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'siege' => $this->siege,
            'capital' => $this->capital,
            'sigle' => $this->sigle,
            'smartphone' => $this->smartphone,
            'phone' => $this->phone,
            'email' => $this->email,
            'primaire' => $this->primaire,
            'secondaire' => $this->secondaire,
            'created_at' => $this->created_at,
            'timbre_loyer' => $this->timbre_loyer,
            'boite_postale' => $this->boite_postale,
            'logo' => $this->whenLoaded(config('constants.COLLECTION_MEDIA_LOGO'), fn() => $this->logo->getUrl()),
        ];
    }
}
