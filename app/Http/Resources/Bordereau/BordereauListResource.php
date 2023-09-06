<?php

namespace App\Http\Resources\Bordereau;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class BordereauListResource extends JsonResource
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
            'code' => $this->code,
            'status' => $this->whenAppended('status'),
            'commercial_id' => $this->commercial_id,
            'date_attribution' => $this->date_attribution,
            'commercial' => $this->whenLoaded('commercial', fn () => Str::lower($this->commercial->user->name)),
        ];
    }
}
