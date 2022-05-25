<?php

  namespace App\Http\Resources;

  use App\Models\NodeType;
  use Illuminate\Http\Resources\Json\ResourceCollection;

  class NodeCollection extends ResourceCollection
  {
    /**
     * Transform the resource collection into an array.
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray ($request)
    {
      return [
        'rows' => $this->collection->map(function ($data) {
          return [
            'id'          => $data->id,
            'title'       => $data->title,
            'description' => $data->description,
            'files'       => LibraryResource::collection($data->files),
            'node_type'   => NodeType::find($data->node_type_id)->name,
            'yoflo_id'    => $data->yoflo_id,
            'coordinates' => $data->coordinates,
          ];
        }),
      ];
    }
  }
