<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\Employee\CalendarController;
use App\Http\Controllers\Employee\CampaignController;
use App\Http\Controllers\Employee\DashboardController;
use App\Http\Controllers\Employee\DevicesController;
use App\Http\Controllers\Employee\FinancialController;
use App\Http\Controllers\Employee\FollowupController;
use App\Http\Controllers\Employee\PatientController;
use App\Http\Controllers\Employee\ReportController;
use App\Http\Controllers\Employee\SettingController;
use App\Http\Controllers\Employee\TasksController;
use App\Http\Controllers\Employee\TreatmentController;
use App\Http\Controllers\Employee\TurnController;
use App\Http\Controllers\Employee\WarehouseController;
use App\Http\Controllers\ShiftReportController;
use Illuminate\Support\Facades\Route;

// ================ Auth Routes ================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ================ Protected Routes (Authenticated) ================
Route::middleware('auth')->group(function () {
    
    Route::prefix('employee')->group(function () {
        Route::get('/', [DashboardController::class, 'dashboardIndex'])->name('dashboard.index');

        //روت های  بخش بیماران
        Route::prefix('patients')->group(function () {
            Route::get('/', [PatientController::class, 'patientIndex'])->name('patient.index');
        });

        //روت های  بخش نوبت ها
        Route::prefix('turn')->group(function () {
            Route::get('/', [TurnController::class, 'turnIndex'])->name('turn.index');
        });

        //روت های  بخش تقویم ها
        Route::prefix('calendar')->group(function () {
            Route::get('/', [CalendarController::class, 'calendarIndex'])->name('calendar.index');
        });

        //روت های  بخش مرکز وظایف
        Route::prefix('task')->group(function () {
            Route::get('/', [TasksController::class, 'taskIndex'])->name('task.index');
            Route::post('/add', [TasksController::class, 'taskAdd']);
        });

        //روت های  بخش درمان ها
        Route::prefix('treatment')->group(function () {
            Route::get('/', [TreatmentController::class, 'treatmentIndex'])->name('treatment.index');
        });

        //روت های  بخش پیگیری ها
        Route::prefix('followup')->group(function () {
            Route::get('/', [FollowupController::class, 'followupIndex'])->name('followup.index');
        });

        //روت های  بخش کمپین ها
        Route::prefix('campaign')->group(function () {
            Route::get('/', [CampaignController::class, 'campaignIndex'])->name('campaign.index');
        });

        //روت های  بخش انبار
        Route::prefix('warehouse')->group(function () {
            Route::get('/', [WarehouseController::class, 'warehouseIndex'])->name('warehouse.index');
        });

        //روت های  بخش دستگاه ها
        Route::prefix('device')->group(function () {
            Route::get('/', [DevicesController::class, 'deviceIndex'])->name('device.index');
        });

        //روت های  بخش مالی
        Route::prefix('financial')->group(function () {
            Route::get('/', [FinancialController::class, 'financialIndex'])->name('financial.index');
        });

        //روت های  بخش گزارش ها
        Route::prefix('report')->group(function () {
            Route::get('/', [ReportController::class, 'reportIndex'])->name('report.index');
        });

        //روت های  بخش تنظیمات
        Route::prefix('setting')->group(function () {
            Route::get('/', [SettingController::class, 'settingIndex'])->name('setting.index');
        });
    });
});