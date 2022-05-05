<?php

  use Illuminate\Support\Facades\Route;
  use App\Http\Controllers\API\Auth\LoginController;
  use App\Http\Controllers\API\Auth\RegistrationController;
  use App\Http\Controllers\API\Auth\ResetPasswordController;
  use App\Http\Controllers\API\Auth\forgotPasswordController;
  use App\Http\Controllers\API\Subscription\SubscriptionController;
  use \App\Http\Controllers\API\UserSubscription\UserSubscriptionController;

  /*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
  */

  /*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
      return $request->user();
  });*/

  Route::post('sign-up', [RegistrationController::class, 'register']);
  Route::post('login', [LoginController::class, 'login']);
  Route::post('request-password', [forgotPasswordController::class, 'forgotPassword']);
  Route::post('reset-email-password', [forgotPasswordController::class, 'resetPassword']);
  Route::get('subscription', [SubscriptionController::class,'index']);


  Route::group(['middleware' => ['auth:sanctum', 'role:user']], function() {
    // Auth routes
    Route::post('logout', [LoginController::class, 'logout']);
    Route::post('change-password', [ResetPasswordController::class, 'changePassword']);

    //User routes
    Route::post('user-subscription', [UserSubscriptionController::class, 'index']);
    Route::post('user-subscription', [UserSubscriptionController::class, 'update']);

  });
