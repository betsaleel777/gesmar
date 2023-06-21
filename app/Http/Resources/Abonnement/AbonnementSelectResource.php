<?php

namespace App\Http\Resources\Abonnement;

use Illuminate\Http\Resources\Json\JsonResource;

class AbonnementSelectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'texte' => $this->texte,
        ];
    }
}
