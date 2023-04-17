<?php

namespace App\Http\Resources\Caisse;

use Illuminate\Http\Resources\Json\JsonResource;

class ChequeResource extends JsonResource
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
            'montant' => $this->montant,
            'banque_id' => $this->banque_id,
            'compte_id' => $this->compte_id,
            'numero' => $this->numero,
            'valeur' => $this->valeur,
            'banque' => BanqueResource::make($this->whenLoaded('banque')),
            'compte' => CompteResource::make($this->whenLoaded('compte')),
        ];
    }
}
