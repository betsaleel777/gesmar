<?php

namespace App\Http\Resources\Caisse;

use App\Models\Finance\Cheque;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Cheque resource
 */
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
            'montant' => $this->whenNotNull($this->montant),
            'banque_id' => $this->whenNotNull($this->banque_id),
            'compte_id' => $this->whenNotNull($this->compte_id),
            'numero' => $this->whenNotNull($this->numero),
            'valeur' => $this->whenNotNull($this->valeur),
            'banque' => BanqueResource::make($this->whenLoaded('banque')),
            'compte' => CompteResource::make($this->whenLoaded('compte')),
        ];
    }
}
