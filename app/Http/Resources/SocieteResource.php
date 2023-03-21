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
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'siege' => $this->siege,
            'capital' => $this->capital,
            'sigle' => $this->sigle,
        ];
    }
}
