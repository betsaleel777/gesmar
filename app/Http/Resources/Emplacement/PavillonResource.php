<?php

namespace App\Http\Resources\Emplacement;

use App\Http\Resources\SiteResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PavillonResource extends JsonResource
{
    public static $wrap = 'pavillon';
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
            'code' => $this->whenAppended('code'),
            'site' => SiteResource::make($this->whenLoaded('site')),
        ];
    }
}
