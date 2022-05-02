<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class forgotPasswordController extends Controller
{
    //
  // send email with instruction
  public function forgotPassword(Request $request)
  {
    $success = false;
    $error = '';
    $payload = null;

    $validator = Validator::make($request->all(),
      [
        'email' => 'required|email|exists:users,email',
      ]);

    if ($validator->fails()) {
      $error = $validator->errors();
      return [
        'success' => $success,
        'error' => $error
      ];
    }


    $status = Password::sendResetLink(
      $request->only('email')
    );

    if($status === Password::RESET_LINK_SENT) {
      return response()->json(['message' => __($status)], 200);
    } else {
      throw ValidationException::withMessages([
        'email' => __($status)
      ]);
    }
  }
}
