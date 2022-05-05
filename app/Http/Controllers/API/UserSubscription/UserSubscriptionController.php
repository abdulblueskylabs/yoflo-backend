<?php

  namespace App\Http\Controllers\API\UserSubscription;

  use App\Http\Controllers\Controller;
  use App\Http\Resources\SubscriptionCollection;
  use App\Http\Resources\UserCollection;
  use App\Http\Resources\UserSubscriptionCollection;
  use App\Models\Subscription;
  use App\Models\User;
  use Carbon\Carbon;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;


  class UserSubscriptionController extends Controller
  {
    /**
     * Display a listing of the active subscriptions Tier Details
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
      $user = Auth::user();

      if (!$user)
        return $this->sendError(['message' => 'No data available']);
      return $this->sendResponse(new UserSubscriptionCollection($user->subscriptions));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $user = Auth::user();

      if (!$user || !$id)
        return $this->sendError(['message' => 'No data available']);
      else
      {
        $current_subscription=$user->subscriptions()->wherePivot('is_active',1)->first();

        $attributes=['end'=>Carbon::now(), 'is_active'=>0];
        $user->subscriptions()->updateExistingPivot($current_subscription,$attributes);
        $subscription=Subscription::findOrFail($id);
        $user->subscriptions()->attach($subscription,['start'=>now(),'is_active'=>1]);
        return $this->sendResponse(['newSubscription' => $subscription->name] );
      }

    }

  }
