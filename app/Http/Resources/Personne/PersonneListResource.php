<?php

namespace App\Http\Resources\Personne;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonneListResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->whenNotNull($this->code),
            'nom' => $this->whenNotNull($this->nom),
            'prenom' => $this->whenNotNull($this->prenom),
            'ville' => $this->whenNotNull($this->ville),
            'contact' => $this->whenNotNull($this->contact),
            'adresse' => $this->whenNotNull($this->adresse),
            'dossier' => $this->whenNotNull($this->getComplet()),
            'site' => $this->whenLoaded('site', fn() => $this->site->nom),
        ];
    }
}
