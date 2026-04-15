<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\EmailVerificationController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');  //sanctum api

//Registeration
Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::delete('logout', 'logout')->middleware('auth:sanctum'); //this middlware get the currnt user to logout
});

//CRUD
Route::controller(CategoryController::class)->group(function () {
    Route::get('all-categories', 'index');
    Route::get('show-category/{id}', 'show');
    Route::post('create-category', 'create')->middleware('role:admin');
});

Route::middleware(['auth:sanctum', 'role:admin'])->controller(CategoryController::class)->group(function () {
    Route::post('create-category', 'create');
    Route::put('update-category/{id}', 'update');
    Route::delete('delete-category/{id}', 'delete');
});


Route::middleware('auth:sanctum')->group(function(){
    Route::post('verify-email',[EmailVerificationController::class,'verifyEmail']);
});
