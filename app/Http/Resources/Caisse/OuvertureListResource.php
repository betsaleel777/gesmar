<?php

namespace App\Http\Resources\Caisse;

use Illuminate\Http\Resources\Json\JsonResource;

class OuvertureListResource extends JsonResource
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
            'guichet_id' => $this->guichet_id,
            'caissier_id' => $this->caissier_id,
            'date' => $this->date,
            'created_at' => $this->created_at,
            'status' => $this->whenAppended('status'),
            'site' => $this->when(
                $this->relationLoaded('guichet') and $this->guichet->relationLoaded('site'),
                fn () => $this->guichet->site->nom
            ),
            'caissier' => $this->when(
                $this->relationLoaded('caissier') and $this->caissier->relationLoaded('user'),
                fn () => $this->caissier->user->name
            ),
            'guichet' => $this->whenLoaded('guichet', fn () => $this->guichet->nom),
        ];
    }
}
