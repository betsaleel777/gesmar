<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
            'nom' => Str::lower($this->nom),
            'pays' => $this->pays,
            'ville' => $this->ville,
            'commune' => $this->commune,
            'postale' => $this->postale,
        ];
    }
}
