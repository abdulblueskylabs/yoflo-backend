<?php

  namespace App\Http\Controllers\API\Auth;

  use App\Http\Controllers\Controller;
  use App\Models\Subscription;
  use App\Models\User;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Hash;
  use Spatie\Permission\Models\Role;
  use Illuminate\Support\Facades\DB;

  class RegistrationController extends Controller
  {
    //
    //Register user for Api user
    public function register(Request $request)
    {

      $request->validate(
        [
          'first_name' => 'required|string',
          'last_name' => 'required|string',
          'phone' => 'required|unique:users',
          'email' => 'required|email|max:191|unique:users,email',
          'password' => 'required|string|min:7',
          'password_confirmation' => 'required| same:password',
          'subscription_id' => 'required',
        ]);

      $name = $request->first_name . $request->last_name;
      if (!str_contains($request->password, $name)) {
        DB::beginTransaction();
        $user = User::create([
          'first_name' => $request['first_name'],
          'last_name' => $request['last_name'],
          'email' => $request['email'],
          'phone' => $request['phone'],
          'is_active' => 0,
          'password' => Hash::make($request['password']),
        ]);
        $subscription = Subscription::findOrFail($request->subscription_id);
        $user->subscriptions()->attach($subscription, ['start_date' => now(), 'is_active' => 1]);
        $user->assignRole('user');
        $token = $user->createToken($request['email'])->plainTextToken;
        DB::commit();
        $payload = ['token' => $token];
        return $this->sendResponse($payload);

      }
      $error = ['message' => 'Does not match your name'];
      return $this->sendError($error);
    }
  }
