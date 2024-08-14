<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users', [UserController::class, 'api_view']);
Route::post('users/create', [UserController::class, 'api_create']);
Route::put('users/edit/{user}', [UserController::class, 'api_update']);
Route::delete('users/delete/{user}', [UserController::class, 'api_delete']);
