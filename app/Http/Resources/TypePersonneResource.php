<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TypePersonneResource extends JsonResource
{
    public static $wrap = 'type';
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
            'site_id' => $this->site_id,
            'site' => SiteResource::make($this->whenLoaded('site')),
        ];
    }
}
