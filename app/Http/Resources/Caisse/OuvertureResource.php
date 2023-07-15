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
            'code' => $this->code,
            'guichet_id' => $this->guichet_id,
            'caissier_id' => $this->caissier_id,
            'date' => $this->date->format('d-m-Y'),
            'created_at' => $this->created_at->format('d-m-Y'),
            'montant' => $this->montant,
            'status' => $this->whenAppended('status'),
            'caissier' => $this->whenLoaded('caissier', fn () => $this->caissier),
            'guichet' => $this->whenLoaded('guichet', GuichetResource::make($this->guichet)),
            'total' => $this->when(
                $this->relationLoaded('encaissements'),
                function () {
                    $total = 0;
                    foreach ($this->encaissements as $encaissement) {
                        $total += $encaissement->relationLoaded('ordonnancement') ? $encaissement->ordonnancement->total : 0;
                    }
                    return $total;
                },
                0
            ),
        ];
    }
}
