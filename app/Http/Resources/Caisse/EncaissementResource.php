<?php

namespace App\Http\Resources\Caisse;

use App\Http\Resources\Personne\PersonneResource;
use App\Models\Finance\Cheque;
use App\Models\Finance\Espece;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class EncaissementResource extends JsonResource
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
            'ordonnancement_id' => $this->ordonnancement_id,
            'created_at' => $this->created_at->format('d-m-Y'),
            'type' => str($this->payable_type)->explode('\\')[3],
            'payable_id' => $this->payable_id,
            'caissier_id' => $this->caissier_id,
            'status' => $this->whenAppended('status'),
            'code' => $this->whenLoaded('ordonnancement', fn () => $this->ordonnancement->code),
            'emplacement' => $this->when(
                $this->relationLoaded('ordonnancement') and $this->ordonnancement->relationLoaded('emplacement'),
                fn () => $this->ordonnancement->emplacement->code
            ),
            'personne' => $this->when(
                $this->relationLoaded('ordonnancement') and $this->ordonnancement->relationLoaded('personne'),
                fn () => PersonneResource::make($this->ordonnancement->personne)
            ),
            'guichet' => $this->when(
                $this->relationLoaded('ouverture') and $this->ouverture->relationLoaded('guichet'),
                fn () => Str::upper($this->ouverture->guichet->nom)
            ),
            'caissier' => $this->when(
                $this->relationLoaded('caissier') and $this->caissier->relationLoaded('user'),
                fn () => Str::lower($this->caissier->user->name)
            ),
            'payable' => $this->when($this->relationLoaded('payable'), function () {
                return match (true) {
                    $this->payable instanceof Cheque => ChequeResource::make($this->payable),
                    $this->payable instanceof Espece => EspeceResource::make($this->payable),
                };
            }),
        ];
    }
}
