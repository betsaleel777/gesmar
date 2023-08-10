<?php

namespace App\Http\Resources\Caisse;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class GuichetListResource extends JsonResource
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
            'site_id' => $this->site_id,
            'nom' => Str::lower($this->nom),
            'created_at' => $this->created_at->format('d-m-Y'),
            'site' => $this->whenLoaded('site', fn () => Str::lower($this->site->nom))
        ];
    }
}
