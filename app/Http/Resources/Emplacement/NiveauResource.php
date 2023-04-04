<?php

namespace App\Http\Resources\Emplacement;

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
            'code' => $this->code,
            'pavillon_id' => $this->pavillon_id,
            'pavillon' => PavillonResource::make($this->whenLoaded('pavillon')),
        ];
    }
}
