<?php

namespace App\Http\Resources\Contrat;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ContratCollection extends ResourceCollection
{
    public static $wrap = "contrats";
    public $collects = ContratResource::class;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): Arrayable
    {
        return $this->collection;
    }
}
