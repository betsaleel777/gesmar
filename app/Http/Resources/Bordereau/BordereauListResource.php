<?php

namespace App\Http\Resources\Bordereau;

use App\Models\Bordereau\Bordereau;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Bordereau resource
 */
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
            'jour' => $this->jour,
            'status' => $this->status,
            'commercial' => $this->when($this->relationLoaded('commercial') and $this->commercial->relationLoaded('user'),
                str($this->resource->commercial->user->name)->lower()),
            'site' => $this->whenLoaded('site', str($this->resource->site->nom)->lower()),
        ];
    }
}
