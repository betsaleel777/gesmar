<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SiteCollection extends ResourceCollection
{
    public static $wrap = 'sites';
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
