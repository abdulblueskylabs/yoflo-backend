<?php

  namespace App\Http\Resources;

  use Illuminate\Http\Resources\Json\ResourceCollection;

  class UserSubscriptionCollection extends ResourceCollection
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
            'type' => $data->name,
            'startDate' => $data->pivot->start_date,
            'endDate' => $data->pivot->end_date,
            'is_active' => $data->pivot->is_active

          ];
        })
      ];
    }
  }
