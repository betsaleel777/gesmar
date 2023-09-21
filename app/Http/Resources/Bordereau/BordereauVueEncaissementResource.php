<?php

namespace App\Http\Resources\Bordereau;

use App\Models\Finance\Bordereau;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Bordereau $resource
 */
class BordereauVueEncaissementResource extends JsonResource
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
            'commercial' => $this->when(
                $this->resource->relationLoaded('commercial') and $this->resource->commercial->relationLoaded('user'),
                $this->resource->commercial->user->name
            ),
            'total' => $this->whenLoaded('attributions', $this->resource->attributions->sum('collecte.montant')),
        ];
    }
}
