<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;
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


Route::apiResource('tasks', TaskController::class)->names([
    'index' => 'api.tasks.index',
    'store' => 'api.tasks.store',
    'show' => 'api.tasks.show',
    'update' => 'api.tasks.update',
    'destroy' => 'api.tasks.destroy',
]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
