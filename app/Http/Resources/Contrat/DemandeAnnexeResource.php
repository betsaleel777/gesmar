<?php

namespace App\Http\Resources\Contrat;

use Illuminate\Http\Resources\Json\JsonResource;

class DemandeAnnexeResource extends JsonResource
{
    public static $wrap = 'contrat';
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
            'created_at' => $this->created_at,
            'status' => $this->whenAppended('status'),
            'annexe' => $this->whenLoaded('annexe', fn () => $this->annexe->nom),
            'personne' => $this->whenLoaded('personne', fn () => $this->personne->alias),
        ];
    }
}
