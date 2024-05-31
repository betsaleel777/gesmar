<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'model_type' => $this->model_type,
            'model_id' => $this->model_id,
            'collection_name' => $this->collection_name,
            'file_name' => $this->file_name,
            'mime_type' => $this->mime_type,
            'size' => $this->size,
            'disk' => $this->disk,
            'original_url' => $this->original_url,
            'preview_url' => $this->preview_url,
        ];
    }
}
