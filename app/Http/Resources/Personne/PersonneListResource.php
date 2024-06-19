<?php

namespace App\Http\Resources\Personne;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonneListResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'ville' => $this->ville,
            'contact' => $this->contact,
            'dossier' => $this->whenNotNull($this->getComplet()),
            'site' => $this->whenLoaded('site', fn () => $this->site->nom),
        ];
    }
}
