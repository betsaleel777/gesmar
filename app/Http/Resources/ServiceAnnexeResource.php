<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceAnnexeResource extends JsonResource
{
    public static $wrap = 'annexe';
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code', $this->code,
            'nom', $this->nom,
            'site_id', $this->site_id,
            'prix', $this->prix,
            'description', $this->description,
            'site', SiteResource::make($this->whenLoaded('site')),
        ];
    }
}
