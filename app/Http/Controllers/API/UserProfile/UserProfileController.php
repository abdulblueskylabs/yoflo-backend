<?php

  namespace App\Http\Controllers\API\UserProfile;

  use App\Http\Controllers\Controller;
  use App\Http\Resources\UserCollection;
  use App\Http\Traits\ResponseTrait;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;

  class UserProfileController extends Controller
  {
    use ResponseTrait;

    /**
     * Display a listing of the user's with current subscription
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
      $user = Auth::user();
      $current_subscription = $user->activeSubscriptions()->first();

      if ($current_subscription->isEmpty())
        return $this->sendError(['message' => 'No data available']);

      $response = ['firstName' => $user->first_name, 'lastName' => $user->last_name, 'email' => $user->email, 'emailVerified' => $user->email_verified_at, 'subscriptionType' => $current_subscription->name];
      return $this->sendResponse($response);
    }


    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update (Request $request)
    {

      $request->validate(
        [
          'first_name' => 'required',
          'last_name'  => 'required',
        ]);

      $user = Auth::user();

      $user->first_name = $request->first_name;
      $user->last_name = $request->last_name;
      $user->save();
      $response = ['name' => $user->first_name . ' ' . $user->last_name];
      return $this->sendResponse($response);

    }

  }
