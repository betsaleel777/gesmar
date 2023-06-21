<?php

namespace App\Http\Resources\Emplacement;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class NiveauListResource extends JsonResource
{
    public static $wrap = 'niveaux';
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'nom' => Str::lower($this->nom),
            'created_at' => $this->created_at->format('d-m-Y'),
            'pavillon' => $this->whenLoaded('pavillon', fn () => Str::lower($this->pavillon->nom)),
            'site' => $this->whenLoaded('site', fn () => Str::lower($this->site->nom)),
        ];
    }
}
