<?php

  namespace App\Http\Controllers\API\Auth;

  use App\Http\Controllers\Controller;
  use App\Models\User;
  use http\Client\Response;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\Hash;
  use Illuminate\Support\Facades\Validator;
  use Laravel\Sanctum\PersonalAccessToken;

  class LoginController extends Controller
  {

    // Login function for Api user
    public function login(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'email' => 'required|email|max:191',
        'password' => 'required|string',
      ]);

      if ($validator->fails()) {
        $error = $validator->errors();
        return $this->sendError($error);
      }

      $user = User::where('email', $request['email'])->first();

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
    public function logout(Request $request)
    {
      // Revoke the token that was used to authenticate the current request
      $request->user()->currentAccessToken()->delete();
      $payload = ['token' => 'logged out Successfully'];
      return $this->sendResponse($payload);
    }

  }
