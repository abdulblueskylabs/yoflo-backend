<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    //
  //Register user for Api user
  public function register(Request $request)
  {
    $success = false;
    $error = '';
    $payload = null;

    $validator = Validator::make($request->all(),
      [
        'name' => 'required',
        'phone' => 'required|unique:users',
        'email' => 'required|email|max:191|unique:users,email',
        'password' => 'required|string|min:7',
        'is_admin' => 'required',
        'password_confirmation' => 'required| same:password'
      ]);
    if ($validator->fails()) {

      $error = $validator->errors();
      return [
        'success' => $success,
        'error' => $error
      ];
    }

    if (!str_contains($request->password, $request->name)) {
      $user = User::create([
        'name' => $request['name'],
        'email' => $request['email'],
        'phone' => $request['phone'],
        'is_admin' => $request['is_admin'],
        'is_active' => 0,
        'password' => Hash::make($request['password']),
      ]);

      $token = $user->createToken($request['email'])->plainTextToken;
      $payload = ['token' => $token];
      $success = true;
      $response = [
        'success' => $success,
        'payload' => $payload
      ];
      return response($response, 201);

    }
    $error = ['message' => 'Does not match your name'];
    return response([
      'success' => $success,
      'error' => $error,
    ], 401);
  }
}
