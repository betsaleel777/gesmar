<?php

namespace App\Http\Resources\Emplacement;

use App\Http\Resources\SiteResource;
use App\Models\Architecture\Pavillon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Pavillon resource
 */
class PavillonResource extends JsonResource
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
            'code' => $this->whenNotNull($this->getCode()),
            'site_id' => $this->whenNotNull($this->site_id),
            'nom' => $this->when(!empty($this->nom), str($this->nom)->lower()),
            'created_at' => $this->whenNotNull($this->created_at?->format('d-m-Y')),
            'site' => SiteResource::make($this->whenLoaded('site')),
        ];
    }
}
