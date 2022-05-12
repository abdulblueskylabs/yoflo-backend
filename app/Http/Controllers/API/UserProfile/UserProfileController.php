<?php

  namespace App\Http\Controllers\API\UserProfile;

  use App\Http\Controllers\Controller;
  use App\Http\Resources\UserCollection;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;

  class UserProfileController extends Controller
  {
    /**
     * Display a listing of the user's with current subscription
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
      $user = Auth::user();
      $current_subscription = $user->activeSubscriptions()->first();

      if (!$user || !$current_subscription)
        return $this->sendError(['message' => 'No data available']);

      $response = ['firstName' => $user->first_name, 'lastName' => $user->last_name, 'email' => $user->email, 'emailVerified' => $user->email_verified_at, 'subscriptionType' => $current_subscription->name];
      return $this->sendResponse($response);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create ()
    {
      //
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store (Request $request)
    {
      //
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show ($id)
    {
      //
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit ($id)
    {
      //

    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update (Request $request)
    {

      //
      $validated = $request->validate([
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

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy ($id)
    {
      //
    }
  }
