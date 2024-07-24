<?php

namespace App\Http\Resources\Caisse;

use App\Http\Resources\Bordereau\BordereauResource;
use App\Http\Resources\Ordonnancement\OrdonnancementResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EncaissementListeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->whenNotNull($this->code),
            'ordonnancement_id' => $this->whenNotNull($this->ordonnancement_id),
            'payable_id' => $this->whenNotNull($this->payable_id),
            'caissier_id' => $this->whenNotNull($this->caissier_id),
            'status' => $this->whenAppended('status'),
            'created_at' => $this->whenNotNull($this->created_at?->format('d-m-Y')),
            'type' => $this->whenNotNull($this->whenHas('payable_type', str($this->payable_type)->explode('\\')[3])),
            'ordonnancement' => OrdonnancementResource::make($this->whenLoaded('ordonnancement')),
            'bordereau' => BordereauResource::make($this->whenLoaded('bordereau')),
            'caissier' => CaissierResource::make($this->whenLoaded('caissier')),
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
