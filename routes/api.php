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
Route::get('error/401',  [function () {
    return view('errors.token_invalid');
}])->name('error401');
Route::post('recovery-password', [UsersController::class, 'Recovery']);

Route::get('password/reset', [UsersController::class, 'PasswordResetView'])->name('password/reset');
Route::get('password/reset/verify', [UsersController::class, 'RecoveryView'])->name('password/reset/verify')->middleware('recovery:sanctum');
Route::post('password/reset/change', [UsersController::class, 'ChangePasword'])->name('password/reset/change')->middleware('recovery:sanctum');
