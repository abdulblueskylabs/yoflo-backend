<?php

  namespace App\Http\Controllers\API\Auth;

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

      $validator = Validator::make($request->all(),
        [
          'password' => 'required|string|min:7',
          'password_confirmation' => 'required| same:password'
        ]);

      if ($validator->fails()) {
        $error = $validator->errors();
        return $this->sendError($error);
      }

      $user = Auth::user();
      $name = $user->first_name . $user->last_name;
      if (!str_contains($request->password, $name)) {
        $user->password = Hash::make($request['password']);
        $user->save();
        $payload = ['message' => 'Update Successfully'];
        return $this->sendResponse($payload);
      }
      $error = ['message' => 'Does not match your name'];
      return $this->sendError($error);
    }

  }
