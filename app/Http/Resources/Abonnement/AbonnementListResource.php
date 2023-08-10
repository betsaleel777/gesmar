<?php

namespace App\Http\Resources\Abonnement;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class AbonnementListResource extends JsonResource
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
            'code' => Str::upper($this->code),
            'index_fin' => $this->index_fin ?? 0,
            'index_lu' => $this->when(empty($this->index_depart), $this->index_autre, $this->index_depart),
            'created_at' => $this->created_at->format('d-m-Y'),
            'status' => $this->whenAppended('status'),
            'site_id' => $this->whenLoaded('site', fn () => $this->site->id),
            'equipement' => $this->whenLoaded('equipement', fn () => Str::upper($this->equipement->code)),
            'emplacement' => $this->whenLoaded('emplacement', fn () => Str::upper($this->emplacement->code)),
        ];
    }
}
