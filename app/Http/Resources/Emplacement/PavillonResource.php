<?php

namespace App\Http\Resources\Emplacement;

use App\Http\Resources\SiteResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
            'site_id' => $this->site_id,
            'nom' => Str::lower($this->nom),
            'created_at' => $this->created_at->format('d-m-Y'),
            'code' => $this->whenAppended('code'),
            'marche' => $this->whenLoaded('site', fn () => Str::lower($this->site->nom)),
            'site' => SiteResource::make($this->whenLoaded('site')),
        ];
    }
}
