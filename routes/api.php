<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgetPassController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\UserController;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

// Login Route
Route::post('/login', [AuthController::class, 'login']);

// Register Route
Route::post('/register', [AuthController::class, 'register']);

// Forget Password
Route::post('/forget-password', [ForgetPassController::class, 'forgetPassword']);

// Reset Password
Route::post('/reset-password', [ResetController::class, 'resetPassword']);

// Current User Route
Route::get('/user', [UserController::class, 'user'])->middleware('auth:api');
