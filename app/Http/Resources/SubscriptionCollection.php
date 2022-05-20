<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SubscriptionCollection extends ResourceCollection
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
          'tiers'=>$this->collection->map(function ($data){
            return [
              'id' => $data->id,
              'type' => $data->name,
              'storage' => $data->max_storage_quantity,
              'node' => $data->max_node_quantity,
              'share' => $data->max_share_quantity,
              'cost' => $data->cost
            ];
          })

        ];
    }
    // command php artisan make:resource SubscriptionCollection --collection
}
