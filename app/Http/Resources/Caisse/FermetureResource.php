<?php

namespace App\Http\Resources\Caisse;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
            'created_at' => $this->created_at->format('d-m-Y'),
            'caissier' => $this->whenLoaded('ouverture', fn () => Str::lower($this->ouverture->caissier->user->name)),
            'initial' => $this->whenLoaded('ouverture', fn () => (int)$this->ouverture->montant),
            'encaissements' => $this->when(
                $this->relationLoaded('ouverture'),
                fn () => $this->ouverture->relationLoaded('encaissements') ?
                    EncaissementResource::collection($this->ouverture->encaissements) : []
            ),
            'total' => $this->when(
                $this->relationLoaded('ouverture'),
                function () {
                    $total = 0;
                    if (!empty($this->ouverture->encaissements)) {
                        foreach ($this->ouverture->encaissements as $encaissement) {
                            $total += $encaissement->relationLoaded('ordonnancement') ? $encaissement->ordonnancement->total : 0;
                        }
                    }
                    return $total;
                },
                0
            ),
        ];
    }
}
