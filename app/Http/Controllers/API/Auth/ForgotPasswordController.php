<?php

  namespace App\Http\Controllers\API\Auth;

  use App\Http\Controllers\Controller;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Password;
  use Illuminate\Support\Facades\Validator;

  class forgotPasswordController extends Controller
  {
    //
    // send email with instruction
    public function forgotPassword (Request $request)
    {
      $validator = Validator::make($request->all(),
                                   [
                                     'email' => 'required|email|exists:users,email',
                                   ]);

      if ($validator->fails()) {
        $error = $validator->errors();
        return $this->sendError($error);
      }

      $status = Password::sendResetLink(
        $request->only('email')
      );

      if ($status === Password::RESET_LINK_SENT) {
        $payload = ['message' => __($status)];
        return $this->sendResponse($payload);
      } else {
        throw ValidationException::withMessages([
                                                  'email' => __($status),
                                                ]);
      }
    }

    public function resetPassword (Request $request)
    {
      $validator = Validator::make($request->all(),
                                   [
                                     'token'    => 'required',
                                     'email'    => 'required|email',
                                     'password' => 'required|min:7|confirmed',
                                   ]);

    }
  }
