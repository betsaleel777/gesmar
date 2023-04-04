<?php

namespace App\Http\Resources\Emplacement;

use App\Http\Resources\SiteResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TypeEmplacementResource extends JsonResource
{
    public static $wrap = "type";
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
            'prefix' => $this->prefix,
            'auto_valid' => $this->auto_valid,
            'equipable' => $this->equipable,
            'site_id' => $this->site_id,
            'code' => $this->whenAppended('code'),
            'site' => SiteResource::make($this->whenLoaded('site')),
        ];
    }
}
