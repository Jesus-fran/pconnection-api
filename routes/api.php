<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum', 'ability:user']], function () {
    Route::apiResource('rest', UsersController::class);
    Route::post('suscribe', [PaymentController::class, 'ToSuscribe'])->name('suscribe');
    Route::get('current-plan', [UsersController::class, 'currentPlan'])->name('current-plan');
    Route::post('cancel-subscription', [PaymentController::class, 'CancelSubscription'])->name('cancel-subscription');
});

//Autentication
Route::post('register', [UsersController::class, 'store']);
Route::post('login', [UsersController::class, 'Login']);

Route::get('error/401',  [function () {
    return view('errors.token_invalid');
}])->name('error401');

//Recovery password
Route::post('recovery-password', [UsersController::class, 'Recovery']);
Route::get('password/reset', [UsersController::class, 'PasswordResetView'])->name('password/reset');
Route::get('password/reset/verify', [UsersController::class, 'RecoveryView'])->name('password/reset/verify')->middleware('recovery:sanctum');
Route::post('password/reset/change', [UsersController::class, 'ChangePasword'])->name('password/reset/change')->middleware('recovery:sanctum');
