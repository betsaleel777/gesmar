<?php

namespace App\Http\Resources\Emplacement;

use App\Http\Resources\SiteResource;
use App\Models\Architecture\Niveau;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Niveau resource
 */
class NiveauResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'pavillon_id' => $this->whenNotNull($this->pavillon_id),
            'code' => $this->whenNotNull($this->code),
            'nom' => $this->when(!empty($this->nom), str($this->nom)->lower()),
            'created_at' => $this->whenNotNull($this->created_at?->format('d-m-Y')),
            'pavillon' => PavillonResource::make($this->whenLoaded('pavillon')),
            'site' => SiteResource::make($this->whenLoaded('site')),
        ];
    }
}
