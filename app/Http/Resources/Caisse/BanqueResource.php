<?php

namespace App\Http\Resources\Caisse;

use App\Http\Resources\SiteResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BanqueResource extends JsonResource
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
            'sigle' => $this->sigle,
            'nom' => $this->nom,
            'site_id' => $this->site_id,
            'site' => SiteResource::make($this->whenLoaded('site')),
        ];
    }
}
