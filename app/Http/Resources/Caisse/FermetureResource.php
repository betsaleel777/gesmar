<?php

namespace App\Http\Resources\Caisse;

use App\Http\Resources\Ordonnancement\OrdonnancementResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FermetureResource extends JsonResource
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
            'code' => $this->code,
            'ordonnacement_id' => $this->ordonnacement_id,
            'ordonnacement' => OrdonnancementResource::make($this->whenLoaded('ordonnacement')),
            'encaissements' => $this->whenPivotLoaded('encaissement_fermeture', fn () => [
                'encaissement_id' => $this->pivot->encaissement_id,
                'fermeture_id' => $this->pivot->fermeture_id,
            ]),
        ];
    }
}
