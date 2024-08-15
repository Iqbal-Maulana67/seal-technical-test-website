<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
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

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('users', [UserController::class, 'api_view']);
Route::middleware('auth:sanctum')->post('users/create', [UserController::class, 'api_create']);
Route::middleware('auth:sanctum')->put('users/edit/{user}', [UserController::class, 'api_update']);
Route::middleware('auth:sanctum')->delete('users/delete/{user}', [UserController::class, 'api_delete']);

Route::middleware('auth:sanctum')->get('project', [ProjectController::class, 'api_view']);
Route::middleware('auth:sanctum')->post('project/create', [ProjectController::class, 'api_create']);
Route::middleware('auth:sanctum')->put('project/edit/{project}', [ProjectController::class, 'api_update']);
Route::middleware('auth:sanctum')->delete('project/delete/{project}', [ProjectController::class, 'api_delete']);

Route::middleware('auth:sanctum')->get('task', [TaskController::class, 'api_view']);
Route::middleware('auth:sanctum')->post('task/create', [TaskController::class, 'api_create']);
Route::middleware('auth:sanctum')->put('task/edit/{task}', [TaskController::class, 'api_update']);
Route::middleware('auth:sanctum')->delete('task/delete/{task}', [TaskController::class, 'api_delete']);