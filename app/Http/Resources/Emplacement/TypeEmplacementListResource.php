<?php

namespace App\Http\Resources\Emplacement;

use App\Http\Resources\SiteResource;
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
            'nom' => $this->whenNotNull($this->nom),
            'equipable' => $this->whenNotNull($this->equipable),
            'auto_valid' => $this->whenNotNull($this->auto_valid),
            'created_at' => $this->whenNotNull($this->created_at?->format('d-m-Y')),
            'frais_dossier' => $this->whenNotNull($this->frais_dossier),
            'frais_amenagement' => $this->whenNotNull($this->frais_amenagement),
            'site' => SiteResource::make($this->whenLoaded('site')),
        ];
    }
}
