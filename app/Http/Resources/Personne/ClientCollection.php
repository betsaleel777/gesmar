<?php

namespace App\Http\Resources\Personne;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ClientCollection extends ResourceCollection
{
    public static $wrap = "clients";
    public $collects = ClientResource::class;
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
