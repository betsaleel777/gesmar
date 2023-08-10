<?php

namespace App\Http\Resources\Abonnement;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class EquipementListResource extends JsonResource
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
            'nom' => $this->nom,
            'code' => $this->code,
            'site_id' => $this->site_id,
            'prix_unitaire' => $this->prix_unitaire,
            'prix_fixe' => $this->prix_fixe,
            'abonnement' => $this->abonnement,
            'liaison' => $this->liaison,
            'created_at' => $this->created_at->format('d-m-Y'),
            'site' => $this->whenLoaded('site', fn () => Str::lower($this->site->nom)),
            'type' => $this->whenLoaded('type', fn () => Str::upper($this->type->nom)),
        ];
    }
}
