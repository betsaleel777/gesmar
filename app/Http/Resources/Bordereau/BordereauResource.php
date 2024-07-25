<?php

namespace App\Http\Resources\Bordereau;

use App\Http\Resources\Emplacement\EmplacementListResource;
use App\Http\Resources\SiteResource;
use App\Models\Bordereau\Bordereau;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Bordereau $resource
 */
class BordereauResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->whenNotNull($this->code),
            'status' => $this->whenNotNull($this->status),
            'site_id' => $this->whenNotNull($this->site_id),
            'jour' => $this->whenNotNull($this->jour?->format('d-m-Y')),
            'total' => $this->whenNotNull($this->total),
            'exacteCollecte' => $this->whenNotNull($this->getExactAmountToCollect()),
            'commercial' => CommercialResource::make($this->whenLoaded('commercial')),
            'site' => SiteResource::make($this->whenLoaded('site')),
            'emplacements' => EmplacementListResource::collection($this->whenLoaded('emplacements')),
            'collectes' => CollecteResource::collection($this->whenLoaded('collectes')),
        ];
    }
}
