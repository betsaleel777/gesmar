<?php

namespace App\Http\Resources\Caisse;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
            'created_at' => $this->created_at->format('d-m-Y'),
            'guichet' => $this->whenLoaded('ouverture', Str::lower($this->ouverture->guichet->nom)),
            'caissier' => $this->whenLoaded('ouverture', fn () => Str::lower($this->ouverture->caissier->user->name)),
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
