<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/auth')->group(function () {
    Route::post('login',[\App\Http\Controllers\Auth\LoginController::class,'handle'])->name('login');
    Route::post('register',[\App\Http\Controllers\Auth\RegisterController::class,'handle'])->name('register');
    Route::post('logout',[\App\Http\Controllers\Auth\LogoutController::class,'handle'])->name('logout')->middleware('auth:sanctum');
});

Route::apiResource('categories', CategoryController::class);

