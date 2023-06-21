<?php

namespace App\Http\Resources\Emplacement;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class EmplacementListResource extends JsonResource
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
            'superficie' => $this->superficie,
            'loyer' => $this->loyer,
            'pas_porte' => $this->pas_porte,
            'liaison' => $this->liaison,
            'disponibilite' => $this->disponibilite,
            'type' => $this->whenLoaded('type', fn () => Str::lower($this->type->nom)),
        ];
    }
}
