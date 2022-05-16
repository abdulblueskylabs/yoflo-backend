<?php

  namespace App\Http\Controllers\API\Auth;

  use App\Http\Controllers\Controller;
  use App\Http\Traits\ResponseTrait;
  use App\Models\User;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Hash;

  class LoginController extends Controller
  {
    use ResponseTrait;

    // Login function for Api user
    public function login (Request $request)
    {
      $request->validate(
        [
          'email'    => 'required|email|max:191',
          'password' => 'required|string',
        ]);

      $user = User::where('email', $request['email'])->where('is_active',1)->first();

      if (!$user || !Hash::check($request['password'], $user->password)) {
        $error = ['message' => 'Invalid Credentials'];
        return $this->sendError($error);

      } else {
        $token = $user->createToken($request['email'])->plainTextToken;
        $payload = ['token' => $token];
        return $this->sendResponse($payload);
      }

    }

    // Logout function for api user
    public function logout (Request $request)
    {
      // Revoke the token that was used to authenticate the current request
      $request->user()->currentAccessToken()->delete();
      $payload = ['message' => 'logout Successful'];
      return $this->sendResponse($payload);
    }

  }
