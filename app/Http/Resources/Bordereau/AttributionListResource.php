<?php

namespace App\Http\Resources\Bordereau;

use App\Models\Finance\Attribution;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

/**
 * @property Attribution $resource
 */
class AttributionListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     * @return array<string,mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'jour' => $this->resource->jour,
            'created_at' => $this->resource->created_at,
            'status' => $this->whenAppended('status'),
            'bordereau' => $this->whenLoaded('bordereau', fn () => $this->resource->bordereau->code),
            'emplacement' => $this->whenLoaded('emplacement', fn () => $this->resource->emplacement->code),
            'commercial' => $this->when(
                $this->relationLoaded('commercial') and $this->resource->commercial->relationLoaded('user'),
                fn () => Str::lower($this->resource->commercial->user->name)
            ),
        ];
    }
}
