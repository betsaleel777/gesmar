<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteResource extends JsonResource
{
    public static $wrap = 'site';
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'pays' => $this->pays,
            'ville' => $this->ville,
            'commune' => $this->commune,
            'postale' => $this->postale,
        ];
    }
}
