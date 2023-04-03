<?php

namespace App\Http\Resources\Personne;

use Illuminate\Http\Resources\Json\JsonResource;

class ProspectResource extends JsonResource
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
            'prenom' => $this->prenom,
            'ville' => $this->ville,
            'contact' => $this->contact,
            'site' => $this->whenLoaded('site', fn () => $this->site->nom),
        ];
    }
}
