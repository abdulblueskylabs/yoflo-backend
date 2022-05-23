<?php

  use App\Http\Controllers\API\Auth\forgotPasswordController;
  use App\Http\Controllers\API\Auth\LoginController;
  use App\Http\Controllers\API\Auth\RegistrationController;
  use App\Http\Controllers\API\Auth\ResetPasswordController;
  use App\Http\Controllers\API\Subscription\SubscriptionController;
  use App\Http\Controllers\API\UserProfile\UserProfileController;
  use App\Http\Controllers\API\UserSubscription\UserSubscriptionController;
  use App\Http\Controllers\Auth\VerificationController;
  use \App\Http\Controllers\API\Folder\FolderController;
  use \App\Http\Controllers\API\Yoflo\YofloController;
  use \App\Http\Controllers\API\Library\LibraryController;
  use \App\Http\Controllers\API\File\FileController;
  use \App\Http\Controllers\API\Node\NodeController;
  use Illuminate\Support\Facades\Auth;
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


  /* Protected Routes*/
  Route::group(['prefix' => 'user', 'middleware' => ['auth:sanctum', 'role:user', 'is_active']], function () {

    Route::get('test', function()
    {
      $user= Auth::user()->activeSubscriptions()->first();
return $user;
    });

    // Auth routes
    Route::post('logout', [LoginController::class, 'logout']);
    Route::post('change-password', [ResetPasswordController::class, 'changePassword']);

    // User-Subscriptions routes
    Route::get('subscription', [UserSubscriptionController::class, 'index']);
    Route::put('subscription/{id}', [UserSubscriptionController::class, 'update']);

    // User-Profile routes
    Route::get('profile', [UserProfileController::class, 'index']);
    Route::put('profile', [UserProfileController::class, 'update']);

    // Folder routes
    Route::get('folder', [FolderController::class, 'index']);
    Route::get('folder/{id}', [FolderController::class, 'show']);
    Route::post('folder', [FolderController::class, 'store']);
    Route::put('folder/{id}', [FolderController::class, 'update']);

    // Yoflo routes
    Route::get('yoflo', [YofloController::class, 'index']);
    Route::get('yoflo/{folder_id}', [YofloController::class, 'show']);
    Route::post('yoflo', [YofloController::class, 'store']);
    Route::put('yoflo/{folder_id}', [YofloController::class, 'update']);

    // Node routes
    Route::get('node', [NodeController::class, 'index']);
    Route::get('node/{id}', [NodeController::class, 'show']);
    Route::post('node', [NodeController::class, 'store']);
    Route::put('node/{id}', [NodeController::class, 'update']);

    // Library Routes (files connected to the node)
    Route::get('library', [LibraryController::class, 'index']);

    // File Routes
    Route::post('file', [FileController::class, 'store'])->middleware('storage_check');
    Route::put('file/{id}', [FileController::class, 'update']);
    Route::delete('file/{id}', [FileController::class, 'destroy']);

  });
