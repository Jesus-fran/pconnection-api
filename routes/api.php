<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum', 'ability:user,restaurantero']], function () {
    Route::apiResource('rest', UsersController::class);
    Route::post('suscribe', [PaymentController::class, 'ToSuscribe'])->name('suscribe');
    Route::get('current-plan', [UsersController::class, 'currentPlan'])->name('current-plan');
    Route::post('cancel-subscription', [PaymentController::class, 'CancelSubscription'])->name('cancel-subscription');
});

Route::group(['middleware' => ['auth:sanctum', 'ability:restaurantero']], function () {
    Route::post('restaurant/info-basic', [RestaurantController::class, 'getInformationBasic'])->name('info-basic');
    Route::post('restaurant/update-info-basic', [RestaurantController::class, 'UpdateInformationBasic'])->name('update-info-basic');
    Route::post('restaurant/create-new-restaurant', [RestaurantController::class, 'CreateRestaurant']);
    Route::post('restaurant/get-restaurant', [RestaurantController::class, 'getRestaurant']);
    Route::post('restaurant/delete-restaurant', [RestaurantController::class, 'deleteRestaurant']);
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
