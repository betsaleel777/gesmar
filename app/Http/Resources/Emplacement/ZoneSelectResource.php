<?php

namespace App\Http\Resources\Emplacement;

use Illuminate\Http\Resources\Json\JsonResource;

class ZoneSelectResource extends JsonResource
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
            'texte' => $this->nom . ' ' . $this->code . ' ' . $this->whenLoaded('site', fn() => str($this->site->nom)->lower()),
        ];
    }
}
