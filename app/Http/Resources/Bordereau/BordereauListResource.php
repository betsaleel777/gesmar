<?php

namespace App\Http\Resources\Bordereau;

use App\Models\Finance\Bordereau;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

/**
 * @property Bordereau $resource
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
            'id' => $this->resource->id,
            'code' => $this->resource->code,
            'status' => $this->whenAppended('status'),
            'commercial_id' => $this->resource->commercial_id,
            'date_attribution' => $this->resource->date_attribution->format('d-m-Y'),
            'created_at' => $this->resource->created_at->format('d-m-Y'),
            'commercial' => $this->when(
                $this->resource->relationLoaded('commercial') and $this->resource->commercial->relationLoaded('user'),
                Str::lower($this->commercial->user->name)
            ),
        ];
    }
}
