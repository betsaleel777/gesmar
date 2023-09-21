<?php

namespace App\Http\Resources\Bordereau;

use App\Models\Finance\Bordereau;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Bordereau $resource
 */
class BordereauSelectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        return ['id' => $this->resource->id, 'code' => $this->resource->code];
    }
}
