<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('auth.login');
});
Route::group(['namespace' => '\App\Http\Controllers'], function () {
  Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
  Route::post('login', 'Auth\LoginController@login');


// Password Reset Routes...
  Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
  Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
  Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
  Route::post('password/reset', 'Auth\ResetPasswordController@reset');
});


// Protected admin routes
Route::group(['middleware' => ['auth','is_active']], function () {
  Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');
Route::post('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

// Protected user routes
Route::group(['middleware' => ['auth', 'role:user'], 'namespace' => '\App\Http\Controllers'], function () {

});
