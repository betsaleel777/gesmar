<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SocieteResource extends JsonResource
{
    public static $wrap = 'societe';
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'siege' => $this->siege,
            'capital' => $this->capital,
            'sigle' => $this->sigle,
            'logo' => $this->whenLoaded(COLLECTION_MEDIA_LOGO)->getUrl(),
            'created_at' => $this->created_at,
        ];
    }
}
