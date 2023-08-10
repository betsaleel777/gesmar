<?php

namespace App\Http\Resources\Emplacement;

use App\Http\Resources\SiteResource;
use Illuminate\Http\Resources\Json\JsonResource;

class NiveauResource extends JsonResource
{
    public static $wrap = 'niveau';
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
            'code' => $this->code,
            'pavillon_id' => $this->pavillon_id,
            'created_at' => $this->created_at->format('d-m-Y'),
            'site_id' => $this->whenLoaded('site', fn () => $this->site->id),
            'pavillon' => PavillonResource::make($this->whenLoaded('pavillon')),
            'site' => SiteResource::make($this->whenLoaded('site')),
        ];
    }
}
