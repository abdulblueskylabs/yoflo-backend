<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LibraryResource extends JsonResource
{
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
        'fileType' => $this->type,
        'fileName' => $this->name,
        'timeCreated' => $this->created_at,
        'fileSize' => $this->size,
        'url' => $this->url
      ];
    }
}
