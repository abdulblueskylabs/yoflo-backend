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
      $request->validate([
        'password' => 'required|string|min:7',
        'password_confirmation' => 'required| same:password'
      ]);

      $user = Auth::user();
      $name = $user->first_name . ' ' . $user->last_name;
      $password = $request->password;
      if (str_contains(strtolower($password), strtolower($name)) || $this->passContainsName($name, $password)) {
        $error = ['message' => 'Password must not contain name'];
        return $this->sendError($error);
      }

      $user->password = Hash::make($request['password']);
      $user->save();
      $payload = ['message' => 'Update Successful'];

      return $this->sendResponse($payload);

    }

    // Helper function to validate password contains name
    function passContainsName($name, $password)
    {
      foreach (explode(" ", $name) as $toCheck) {
        if (str_contains(strtolower($password), strtolower($toCheck))) {
          return true;
        }
      }
      return false;
    }

  }
