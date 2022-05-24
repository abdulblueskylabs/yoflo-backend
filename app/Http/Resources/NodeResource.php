<?php

  namespace App\Http\Resources;

  use App\Models\Node;
  use Illuminate\Http\Resources\Json\JsonResource;

  class NodeResource extends JsonResource
  {
    /**
     * Transform the resource into an array.
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray ($request)
    {


          return [
        'id'          => $this->id,
        'title'       => $this->title,
        'description' => $this->description,
        'files'       => LibraryResource::collection($this->files),
        'node_type'   => $this->node_type_id,
        'yoflo_id'    => $this->yoflo_id,
        'coordinates' => $this->coordinates,
      ];


    }
  }
