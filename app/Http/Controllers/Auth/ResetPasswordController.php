<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    //
  // Change password function for api user
  public function changePassword(Request $request)
  {
    $success = false;
    $error = '';
    $payload = null;

    $validator = Validator::make($request->all(),
      [
        'password' => 'required|string|min:7',
        'password_confirmation' => 'required| same:password'
      ]);

    if ($validator->fails()) {
      $error = $validator->errors();
      return [
        'success' => $success,
        'error' => $error
      ];
    }

    $user = Auth::user();
    if (!str_contains($request->password, $user->name)) {
      $user->password = Hash::make($request['password']);
      $user->save();
      $success = true;
      $payload = ['message' => 'Update Successfully'];
      $response = [
        'success' => $success,
        'payload' => $payload
      ];
      return response($response, 201);
    }
    $error = ['message' => 'Does not match your name'];
    return response([
      'success' => $success,
      'error' => $error
    ], 401);
  }


}
