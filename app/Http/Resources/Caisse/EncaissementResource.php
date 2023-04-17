<?php

namespace App\Http\Resources\Caisse;

use App\Http\Resources\Ordonnancement\OrdonnancementResource;
use App\Models\Finance\Cheque;
use App\Models\Finance\Espece;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'code' => $this->code,
            'ordonnancement_id' => $this->ordonnancement_id,
            'created_at' => $this->created_at,
            'type' => str($this->payable_type)->explode('\\')[3],
            'payable_id' => $this->payable_id,
            'caissier_id' => $this->caissier_id,
            'status' => $this->whenAppended('status'),
            'ordonnancement' => OrdonnancementResource::make($this->whenLoaded('ordonnancement')),
            'caissier' => $this->when(
                $this->relationLoaded('caissier') and $this->caissier->relationLoaded('user'),
                fn () => $this->caissier->user->name
            ),
            'payable' => $this->when($this->relationLoaded('payable'), function () {
                return match (true) {
                    $this->payable->cheque instanceof Cheque => ChequeResource::make($this->payable->cheque),
                    $this->payable->espece instanceof Espece => EspeceResource::make($this->payable->espece),
                };
            }),
        ];
    }
}
