<?php

  namespace App\Http\Controllers\API\Subscription;

  use App\Http\Controllers\Controller;
  use App\Http\Resources\SubscriptionCollection;
  use App\Http\Traits\ResponseTrait;
  use App\Models\Subscription;
  use Illuminate\Http\Request;

  class SubscriptionController extends Controller
  {
    use ResponseTrait;

    /**
     * Display a listing of the active subscriptions Tier Details
     * @return \Illuminate\Http\Response
     */

    public function index ()
    {
      // Get the active subscriptions
      $subscriptions = Subscription::where('is_active', 1)->get();

      // NO data available
      if ($subscriptions->isEmpty())
        return $this->sendError(['message'=>'No data'], 404);
      else {

        // Return formatted data
        return $this->sendResponse(new SubscriptionCollection($subscriptions));
      }

    }

  }
