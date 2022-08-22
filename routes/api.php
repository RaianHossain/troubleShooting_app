<?php

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/up-for-more/{user_id}/{state}', [UserController::class, 'upForMoreStatus']);
Route::post('/make-notification', [NotificationController::class, 'makeNotification']);
Route::get('/make-notification-seen/{notification_id}/{user_id}', [NotificationController::class, 'makeSeen']);
