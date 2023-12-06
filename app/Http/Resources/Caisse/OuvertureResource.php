<?php

namespace App\Http\Resources\Caisse;

use Illuminate\Http\Resources\Json\JsonResource;

class OuvertureResource extends JsonResource
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
            'code' => $this->whenLoaded($this->code),
            'guichet_id' => $this->whenLoaded($this->guichet_id),
            'caissier_id' => $this->whenLoaded($this->caissier_id),
            'montant' => $this->whenLoaded($this->montant),
            'status' => $this->whenAppended('status'),
            'date' => $this->whenLoaded($this->date?->format('d-m-Y')),
            'created_at' => $this->whenNotNull($this->created_at?->format('d-m-Y')),
            'caissier' => $this->whenLoaded('caissier', fn() => $this->caissier),
            'guichet' => $this->whenLoaded('guichet', GuichetResource::make($this->guichet)),
            'total' => $this->whenNotNull($this->total),
        ];
    }
}
