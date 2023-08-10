<?php

namespace App\Http\Resources\Emplacement;

use Illuminate\Http\Resources\Json\JsonResource;

class ZoneResource extends JsonResource
{
    public static $wrap = 'zone';
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
            'niveau_id' => $this->niveau_id,
            'code' => $this->whenAppended('code'),
            'site_id' => $this->whenLoaded('site', fn () => $this->site->id),
            'niveau' => NiveauResource::make($this->whenLoaded('niveau')),
        ];
    }
}
