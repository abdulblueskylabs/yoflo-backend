<?php

  use Illuminate\Support\Facades\Route;
  use App\Http\Controllers\Auth\LoginController;
  use App\Http\Controllers\Auth\RegistrationController;
  use App\Http\Controllers\Auth\ResetPasswordController;
  use App\Http\Controllers\Auth\forgotPasswordController;

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


  Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [LoginController::class, 'logout']);
    Route::post('change-password', [ResetPasswordController::class, 'changePassword']);

  });

