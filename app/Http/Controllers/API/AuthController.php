<?php

  namespace App\Http\Controllers\API;

  use App\Http\Controllers\Controller;
  use App\Models\User;
  use http\Client\Response;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Hash;
  use Laravel\Sanctum\PersonalAccessToken;

  class AuthController extends Controller
  {


    //Register user for Api user
    public function register(Request $request)
    {
      $data = $request->validate(
        [
          'name' => 'required',
          'email' => 'required|email|max:191|unique:users,email',
          'password' => 'required|string'
        ]);

      $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
      ]);
      $token = $user->createToken($data['email'])->plainTextToken;
      $response = [
        'user' => $user,
        'token' => $token
      ];
      return response($response, 201);

    }

    // Login function for Api user
    public function login(Request $request)
    {

      $data = $request->validate(
        [
          'email' => 'required|email|max:191',
          'password' => 'required|string',
        ]);
      $user = User::where('email', $data['email'])->first();

      if (!$user || !Hash::check($data['password'], $user->password)) {
        return response(['message' => 'Invalid Credentials'], 401);
      } else {
        $token = $user->createToken($data['email'])->plainTextToken;
        $response = [
          'user' => $user,
          'token' => $token
        ];
        return response($response, 201);
      }

    }

    // Logout function for Api user
    public function logout(Request $request)
    {
      auth()->user()->currentAccessToken()->delete();

      return response(['message' => 'logged out Successfully']);

    }


  }
