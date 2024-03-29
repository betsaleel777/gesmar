<?php

namespace App\Http\Resources\Caisse;

use App\Http\Resources\SiteResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CompteResource extends JsonResource
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
            'code' => $this->code,
            'nom' => $this->nom,
            'site_id' => $this->site_id,
            'created_at' => $this->created_at->format('d-m-Y'),
            'site' => SiteResource::make($this->whenLoaded('site')),
        ];
    }
}
