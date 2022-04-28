<?php

  namespace App\Http\Controllers\API;

  use App\Http\Controllers\Controller;
  use App\Models\User;
  use http\Client\Response;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
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
          'phone' => 'required|unique:users',
          'email' => 'required|email|max:191|unique:users,email',
          'password' => 'required|string|min:7',
          'is_admin' => 'required',
          'password_confirmation' => 'required| same:password'
        ]);

      if (!str_contains($request->password, $request->name)) {
        $user = User::create([
          'name' => $data['name'],
          'email' => $data['email'],
          'phone' => $data['phone'],
          'is_admin' => $data['is_admin'],
          'is_active' => 0,
          'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken($data['email'])->plainTextToken;
        $response = [
          'user' => $user,
          'token' => $token
        ];
        return response($response, 201);

      }
      return response(['message' => ' Does not match your name'], 401);
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

    // Logout function for api user
    public function logout()
    {
      auth()->user()->currentAccessToken()->delete();
      return response(['message' => 'logged out Successfully']);
    }

    // Change password function for api user
    public function changePassword(Request $request)
    {
      $data = $request->validate(
        [
          'password' => 'required|string|min:7',
          'password_confirmation' => 'required| same:password'
        ]);

      $user = Auth::user();
      if (!str_contains($request->password, $user->name)) {
        $user->password = Hash::make($data['password']);
        $user->save();
        return response(['message' => 'Update Successfully'], 201);
      }
      return response(['message' => ' Does not match your name'], 401);
    }

    // send email with instruction
    public function forgotPassword(Request $request)
    {
      $data = $request->validate(
        [
          'email' => 'required|email|max:191',
        ]);
      $user = Auth::user();
      if (User::where('email', $data['email'])->first()) {

      }
    }

  }
