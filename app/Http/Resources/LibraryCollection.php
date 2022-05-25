<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LibraryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
      return [
        'data'=>$this->collection->map(function ($data){
          return [
            'id' => $data->id,
            'fileType' => $data->type,
            'fileName' => $data->name,
            'timeCreated' => $data->created_at,
            'fileSize' => $data->size,
            'url' => $data->url
          ];
        })
      ];
    }
}
