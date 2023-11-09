<?php

namespace App\Http\Resources\Emplacement;

use App\Http\Resources\SiteResource;
use App\Models\Architecture\TypeEmplacement;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property TypeEmplacement resource
 */
class TypeEmplacementResource extends JsonResource
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
            'code' => $this->when(!empty($this->getCode()), $this->getCode()),
            'nom' => $this->when(!empty($this->nom), str($this->nom)->lower()),
            'prefix' => $this->when(!empty($this->prefix), str($this->prefix)->upper()),
            'auto_valid' => $this->whenNotNull($this->auto_valid),
            'equipable' => $this->whenNotNull($this->equipable),
            'site' => SiteResource::make($this->whenLoaded('site')),
        ];
    }
}
