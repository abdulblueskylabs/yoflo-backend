<?php

  namespace App\Http\Controllers\API;

  use App\Http\Controllers\Controller;
  use App\Models\User;
  use http\Client\Response;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\Hash;
  use Illuminate\Support\Facades\Validator;
  use Laravel\Sanctum\PersonalAccessToken;

  class AuthController extends Controller
  {

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

        $error = $validator->errors()->all();
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

    // Login function for Api user
    public function login(Request $request)
    {
      $success = false;
      $error = '';
      $payload = null;

      $validator = Validator::make($request->all(), [
        'email' => 'required|email|max:191',
        'password' => 'required|string',
      ]);

      if ($validator->fails()) {
        $error = $validator->errors()->all();
        return [
          'success' => $success,
          'error' => $error
        ];
      }

      $user = User::where('email', $request['email'])->first();

      if (!$user || !Hash::check($request['password'], $user->password)) {
        $error = ['message' => 'Invalid Credentials'];
        $response = [
          'success' => $success,
          'error' => $error
        ];

      } else {
        $token = $user->createToken($request['email'])->plainTextToken;
        $payload = ['token' => $token];
        $success = true;
        $response = [
          'success' => $success,
          'payload' => $payload
        ];
      }
      return response($response, 201);

    }

    // Logout function for api user
    public function logout()
    {
      auth()->user()->currentAccessToken()->delete();
      return response(['success' => true, 'payload' => ['message' => 'logged out Successfully']]);
    }

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
        $error = $validator->errors()->all();
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

    // send email with instruction
    public function forgotPassword(Request $request)
    {
      $messages = [
        'success'=>false,
        'error' =>['errors'] ,
      ];
      $data = $request->validate(
        [
          'email' => 'required|email|exists:users,email',
        ],$messages);
      $user = Auth::user();

    }

  }
