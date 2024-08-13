<?php

namespace App\Http\Resources\Personne;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonneSelectResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'alias' => $this->getAlias(),
        ];
    }
}
