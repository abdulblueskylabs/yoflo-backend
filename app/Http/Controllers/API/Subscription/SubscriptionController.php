<?php

  namespace App\Http\Controllers\API\Subscription;

  use App\Http\Controllers\Controller;
  use App\Models\Subscription;
  use Illuminate\Http\Request;

  class SubscriptionController extends Controller
  {

    // Retrieve all active subscriptions Tier Details
    public function index()
    {
      // Get the active subscriptions
      $data = Subscription::where('is_active', 1)->get();

      // NO data available
      if (!$data)
        return $this->sendError('No data', 404);
      else {
        foreach ($data as $subscriptions) {
          $subscription_array[] = [
            'id' => $subscriptions->id,
            'type' => $subscriptions->name,
            'storage' => $subscriptions->max_storage_quantity,
            'node' => $subscriptions->max_node_quantity,
            'share' => $subscriptions->max_share_quantity,
            'cost' => $subscriptions->cost
          ];
        }
        // Return formatted data
        return $this->sendResponse(['tiers' => $subscription_array]);
      }

    }


  }
