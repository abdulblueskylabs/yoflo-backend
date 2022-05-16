<?php

  namespace App\Http\Controllers\API\UserSubscription;

  use App\Http\Controllers\Controller;
  use App\Http\Resources\SubscriptionCollection;
  use App\Http\Resources\UserCollection;
  use App\Http\Resources\UserSubscriptionCollection;
  use App\Http\Traits\ResponseTrait;
  use App\Models\Subscription;
  use App\Models\User;
  use Carbon\Carbon;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;

  class UserSubscriptionController extends Controller
  {
    use ResponseTrait;
    /**
     * Display a listing of the active subscriptions Tier Details
     * @return \Illuminate\Http\Response
     */

    public function index ()
    {
      $user = Auth::user();

      if (!$user)
        return $this->sendError(['message' => 'No data available']);
      return $this->sendResponse(new UserSubscriptionCollection($user->subscriptions));
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update (Request $request, $id)
    {
      $user = Auth::user();

      if (!$user || !$id)
        return $this->sendError(['message' => 'No data available']);
      else {
        // Find existing subscription
        $current_subscription = $user->activeSubscriptions()->first();

        // Update existing subscription
        $attributes = ['end_date' => Carbon::now(), 'is_active' => 0];
        $user->activeSubscriptions()->updateExistingPivot($current_subscription, $attributes);

        // Find new subscription
        $subscription = Subscription::findOrFail($id);

        // Update in pivot table
        $user->subscriptions()->attach($subscription, ['start_date' => now(), 'is_active' => 1]);
        return $this->sendResponse(['newSubscription' => $subscription->name]);
      }

    }

  }
