<?php

namespace App\Http\Resources\Caisse;

use Illuminate\Http\Resources\Json\JsonResource;

class FermetureListResource extends JsonResource
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
            'ordonnancement_id' => $this->ordonnancement_id,
            'ordonnancement' => $this->whenLoaded('ordonnancement', fn () => $this->ordonnancement->code),
            'encaissements' => $this->whenPivotLoaded('encaissement_fermeture', fn () => [
                'encaissement_id' => $this->pivot->encaissement_id,
                'fermeture_id' => $this->pivot->fermeture_id,
            ]),
        ];
    }
}
