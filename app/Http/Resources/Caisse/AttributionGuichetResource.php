<?php

namespace App\Http\Resources\Caisse;

use Illuminate\Http\Resources\Json\JsonResource;

class AttributionGuichetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->pivot->id,
            'code' => $this->code,
            'caissier_id' => $this->pivot->caissier_id,
            'guichet_id' => $this->pivot->guichet_id,
            'date' => $this->pivot->date,
        ];
    }
}
