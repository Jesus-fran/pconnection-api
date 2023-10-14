<?php

use App\Http\Controllers\UsersController;
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

Route::group(['middleware' => ['auth:sanctum', 'ability:user']], function () {
    Route::apiResource('rest', UsersController::class);
});

Route::post('register', [UsersController::class, 'store']);
Route::post('login', [UsersController::class, 'Login']);

