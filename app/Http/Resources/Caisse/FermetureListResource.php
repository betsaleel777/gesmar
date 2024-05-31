<?php

namespace App\Http\Resources\Caisse;

use App\Models\Caisse\Fermeture;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Fermeture resource
 */
class FermetureListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'total' => $this->whenNotNull($this->total),
            'status' => $this->whenNotNull($this->status),
            'created_at' => $this->whenNotNull($this->created_at?->format('d-m-Y')),
            'guichet' => GuichetResource::make($this->whenLoaded('guichet')),
            'caissier' => CaissierResource::make($this->whenLoaded('caissier')),
        ];
    }
}
