<?php

namespace App\Http\Resources\Caisse;

use Illuminate\Http\Resources\Json\JsonResource;

class EncaissementListeResource extends JsonResource
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
            'ordonnancement' => $this->whenLoaded('ordonnancement', fn () => $this->ordonnancement->code),
            'caissier' => $this->when(
                $this->relationLoaded('caissier') and $this->caissier->relationLoaded('user'),
                fn () => $this->caissier->user->name
            ),
            $this->mergeWhen(str($this->payable_type)->explode('\\')[3] === 'Espece', [
                'montant' => $this->payable->montant,
                'versement' => $this->payable->versement,
            ]),
            $this->mergeWhen(str($this->payable_type)->explode('\\')[3] !== 'Espece', [
                'valeur' => $this->payable->valeur,
            ]),
        ];
    }
}
