<?php

use App\Http\Controllers\Admin\Auth\VerificationController;
use App\Http\Controllers\API\Auth\forgotPasswordController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegistrationController;
use App\Http\Controllers\API\Auth\ResetPasswordController;
use App\Http\Controllers\API\Subscription\SubscriptionController;
use App\Http\Controllers\API\UserProfile\UserProfileController;
use App\Http\Controllers\API\UserSubscription\UserSubscriptionController;
use Illuminate\Support\Facades\Route;

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

// All routes have default prefix => api

Route::prefix('user')->group(function () {

  Route::post('sign-up', [RegistrationController::class, 'register']);
  Route::post('login', [LoginController::class, 'login']);
  Route::post('request-password', [forgotPasswordController::class, 'forgotPassword']);
  Route::post('reset-email-password', [forgotPasswordController::class, 'resetPassword']);

});


Route::get('subscriptions', [SubscriptionController::class, 'index']);

Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::get('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

Route::group(['prefix' => 'user', 'middleware' => ['auth:sanctum', 'role:user']], function () {

  // Auth routes
  Route::post('logout', [LoginController::class, 'logout']);
  Route::post('change-password', [ResetPasswordController::class, 'changePassword']);


  // User-Subscriptions routes
  Route::get('subscription', [UserSubscriptionController::class, 'index']);
  Route::put('subscription/{id}', [UserSubscriptionController::class, 'update']);

  // User-Profile routes
  Route::get('profile', [UserProfileController::class, 'index']);
  Route::put('profile', [UserProfileController::class, 'update']);

});
