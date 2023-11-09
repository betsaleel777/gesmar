<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteResource extends JsonResource
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
            'nom' => $this->when(!empty($this->nom), str($this->nom)->lower()),
            'pays' => $this->whenNotNull($this->pays),
            'ville' => $this->whenNotNull($this->ville),
            'commune' => $this->whenNotNull($this->commune),
            'postale' => $this->whenNotNull($this->postale),
        ];
    }
}
