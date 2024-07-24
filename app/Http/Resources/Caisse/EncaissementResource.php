<?php

namespace App\Http\Resources\Caisse;

use App\Http\Resources\Bordereau\BordereauResource;
use App\Http\Resources\Ordonnancement\OrdonnancementResource;
use App\Models\Caisse\Encaissement;
use App\Models\Finance\Cheque;
use App\Models\Finance\Espece;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Encaissement resource
 */
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
            'code' => $this->whenNotNull($this->code),
            'caissier_id' => $this->whenNotNull($this->caissier_id),
            'payable_id' => $this->whenNotNull($this->payable_id),
            'ordonnancement_id' => $this->whenNotNull($this->ordonnancement_id),
            'bordereau_id' => $this->whenNotNull($this->bordereau_id),
            'status' => $this->whenAppended('status'),
            'type' => $this->whenNotNull($this->whenHas('payable_type', str($this->payable_type)->explode('\\')[3])),
            'created_at' => $this->whenNotNull($this->created_at?->format('d-m-Y')),
            'ordonnancement' => OrdonnancementResource::make($this->whenLoaded('ordonnancement')),
            'ouverture' => OuvertureResource::make($this->whenLoaded('ouverture')),
            'caissier' => CaissierResource::make($this->whenLoaded('caissier')),
            'bordereau' => BordereauResource::make($this->whenLoaded('bordereau')),
            'payable' => $this->when($this->relationLoaded('payable'), function () {
                return match (true) {
                    $this->payable instanceof Cheque => ChequeResource::make($this->payable),
                    $this->payable instanceof Espece => EspeceResource::make($this->payable),
                };
            }),
        ];
    }
}
