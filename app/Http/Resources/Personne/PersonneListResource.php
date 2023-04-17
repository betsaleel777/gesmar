<?php

namespace App\Http\Resources\Personne;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonneListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'ville' => $this->ville,
            'contact' => $this->contact,
            'dossier' => $this->whenAppended('complet'),
            'site' => $this->whenLoaded('site', fn () => $this->site->nom),
        ];
    }
}
