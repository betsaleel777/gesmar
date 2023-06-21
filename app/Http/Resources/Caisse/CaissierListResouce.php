<?php

namespace App\Http\Resources\Caisse;

use Illuminate\Http\Resources\Json\JsonResource;

class CaissierListResouce extends JsonResource
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
            'user' => $this->whenLoaded('user', fn () => $this->user->name),
            'created_at' => $this->created_at->format('d-m-Y'),
        ];
    }
}
