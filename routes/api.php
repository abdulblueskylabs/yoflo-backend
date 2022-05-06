<?php

  use Illuminate\Support\Facades\Route;
  use App\Http\Controllers\API\Auth\LoginController;
  use App\Http\Controllers\API\Auth\RegistrationController;
  use App\Http\Controllers\API\Auth\ResetPasswordController;
  use App\Http\Controllers\API\Auth\forgotPasswordController;
  use App\Http\Controllers\API\Subscription\SubscriptionController;
  use \App\Http\Controllers\API\UserSubscription\UserSubscriptionController;
  use \App\Http\Controllers\API\UserProfile\UserProfileController;

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

  Route::post('user/sign-up', [RegistrationController::class, 'register']);
  Route::post('user/login', [LoginController::class, 'login']);
  Route::post('user/request-password', [forgotPasswordController::class, 'forgotPassword']);
  Route::post('user/reset-email-password', [forgotPasswordController::class, 'resetPassword']);
  Route::get('subscriptions', [SubscriptionController::class,'index']);


  Route::group(['middleware' => ['auth:sanctum', 'role:user']], function() {

    // Auth routes
    Route::post('/user/logout', [LoginController::class, 'logout']);
    Route::post('user/change-password', [ResetPasswordController::class, 'changePassword']);

    // User-Subscriptions routes
    Route::get('user/subscription', [UserSubscriptionController::class, 'index']);
    Route::put('user/subscription/{id}', [UserSubscriptionController::class, 'update']);

    // User-Profile routes
    Route::get('user/profile', [UserProfileController::class, 'index']);
    Route::put('user/profile', [UserProfileController::class, 'update']);

  });
