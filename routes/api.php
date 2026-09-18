<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\API\SiteController;
use App\Http\Controllers\API\ServiesController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\SpecialistController;
use App\Http\Controllers\API\AppointmentController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/home', [SiteController::class, 'home']);

Route::get('/services', [ServiesController::class, 'index']);
Route::get('/services/{id}', [ServiesController::class, 'show']);

Route::get('/specialist-profile/{id}', [SpecialistController::class, 'profile']);

Route::get('/profile', [ProfileController::class, 'profile']);
Route::get('/profile/toggle/{toggleName}/{value}', [ProfileController::class, 'toggle']);

Route::get('/doctors/{id?}', [ProfileController::class, 'doctors']);

Route::get('/appointments', [AppointmentController::class, 'index']);
Route::get('/appointment/det/{id}', [AppointmentController::class, 'det']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});