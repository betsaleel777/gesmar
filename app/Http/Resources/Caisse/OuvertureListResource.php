<?php

namespace App\Http\Resources\Caisse;

use Illuminate\Http\Resources\Json\JsonResource;

class OuvertureListResource extends JsonResource
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
            'code' => $this->whenNotNull($this->code),
            'guichet_id' => $this->whenNotNull($this->guichet_id),
            'caissier_id' => $this->whenNotNull($this->caissier_id),
            'date' => $this->whenNotNull($this->date?->format('d-m-Y')),
            'created_at' => $this->whenNotNull($this->created_at?->format('d-m-Y')),
            'montant' => $this->whenNotNull($this->montant, 0),
            'status' => $this->whenAppended('status'),
            'guichet' => GuichetResource::make($this->whenLoaded('guichet')),
            'caissier' => CaissierResource::make($this->whenLoaded('caissier')),
        ];
    }
}
