<?php

  namespace App\Http\Resources;

  use Illuminate\Http\Resources\Json\ResourceCollection;

  class UserCollection extends ResourceCollection
  {
    /**
     * Transform the resource collection into an array.
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

      return [
        'subscriptionHistory' => $this->collection->map(function ($data) {
          return [
            'type' => $data->first_name,
            'startDate' => $data->last_name,
            'endDate' => $data->email,
            'is_active' => $data->email_verified_at

          ];
        })
      ];
    }

  }
