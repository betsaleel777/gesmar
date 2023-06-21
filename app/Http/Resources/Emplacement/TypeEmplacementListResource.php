<?php

namespace App\Http\Resources\Emplacement;

use Illuminate\Http\Resources\Json\JsonResource;

class TypeEmplacementListResource extends JsonResource
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
            'equipable' => $this->equipable,
            'auto_valid' => $this->auto_valid,
            'created_at' => $this->created_at->format('d-m-Y'),
            'site' => $this->whenLoaded('site', fn () => $this->site->nom),
        ];
    }
}
