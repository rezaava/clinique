<?php

use App\Http\Controllers\API\AppointmentController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ConsultationController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\ServiesController;
use App\Http\Controllers\API\SiteController;
use App\Http\Controllers\API\SpecialistController;
use Illuminate\Support\Facades\Route;

// احراز هویت عمومی
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// اطلاعات عمومی سایت
Route::get('/home', [SiteController::class, 'home']);
Route::get('/workdays', [SiteController::class, 'workdays']);

Route::get('/services', [ServiesController::class, 'index']);
Route::get('/services/{id}', [ServiesController::class, 'show']);

Route::get('/specialist-profile/{id}', [SpecialistController::class, 'profile']);

// اطلاعات عمومی پزشکان
Route::get('/doctors/{id?}', [ProfileController::class, 'doctors']);

// APIهای نیازمند احراز هویت با Passport
Route::middleware('auth:api')->group(function () {
    // کاربر
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // پروفایل
    Route::get('/profile', [ProfileController::class, 'profile']);
    Route::get('/profile/toggle/{toggleName}/{value}', [ProfileController::class, 'toggle']);

    // نوبت‌ها
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::get('/freetimes/{date}/{service}', [AppointmentController::class, 'freetimes']);
    Route::get('/appointment/det/{id}', [AppointmentController::class, 'det']);
    Route::post('/booking/no-deposit', [AppointmentController::class, 'NoDepositBooking']);
    Route::post('/booking/deposit', [AppointmentController::class, 'DepositBooking']);
    Route::post('/appointment/cancel/{id}', [AppointmentController::class, 'cancel']);

    // مشاوره
    Route::post('/consultations/store', [ConsultationController::class, 'store']);
});