<?php

namespace App\Http\Resources\Emplacement;

use App\Http\Resources\SiteResource;
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
            'nom' => $this->when(!empty($this->nom), str($this->nom)->lower()),
            'created_at' => $this->created_at->format('d-m-Y'),
            'pavillon' => PavillonResource::make($this->whenLoaded('pavillon')),
            'site' => SiteResource::make($this->whenLoaded('site')),
        ];
    }
}
