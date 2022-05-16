<?php

  namespace App\Http\Controllers\API\Auth;

  use App\Http\Controllers\Controller;
  use App\Http\Traits\ResponseTrait;
  use App\Models\User;
  use Illuminate\Http\Request;

  class EmailVerificationController extends Controller
  {
    use ResponseTrait;
    //

    public function verify ($user_id, Request $request)
    {
      if (!$request->hasValidSignature()) {
        return $this->sendError(['message' => 'unauthorized user']);
      }
      $user = User::findOrFail($user_id);
      if (!$user->hasverifiedEmail()) {
        $user->markEmailAsVerified();
      }

    }

    public function resend ()
    {

    }
  }
