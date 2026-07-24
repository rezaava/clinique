<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BrandController;
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
    // ============== Appointment Routes (Client & Staff) ==============
    Route::prefix('appointments')->group(function () {
        // مشتری: درخواست نوبت جدید
        Route::get('/create', [AppointmentsController::class, 'create'])->name('appointments.create');
        Route::post('/store', [AppointmentsController::class, 'store'])->name('appointments.store');
        
        // مشتری: مشاهده نوبت‌های خود
        Route::get('/my', [AppointmentsController::class, 'myAppointments'])->name('appointments.my');
        
        // مشتری و پرسنل: مشاهده جزئیات نوبت
        Route::get('/{id}', [AppointmentsController::class, 'show'])->name('appointments.show');
        
        // مشتری و پرسنل: تاریخچه نوبت‌ها
        Route::get('/history/{userId?}', [AppointmentsController::class, 'history'])->name('appointments.history');
    });

    // ============== Appointment Management Routes (Staff only) ==============
    Route::prefix('staff/appointments')->middleware(['role:employee|admin'])->group(function () {
        // مدیریت نوبت‌ها (لیست درخواست‌ها)
        Route::get('/', [AppointmentsController::class, 'index'])->name('appointments.manage');
        
        // تأیید نوبت
        Route::post('/confirm', [AppointmentsController::class, 'confirm'])->name('appointments.confirm');
        
        // لغو نوبت
        Route::post('/cancel', [AppointmentsController::class, 'cancel'])->name('appointments.cancel');
        
        // تکمیل نوبت
        Route::post('/complete', [AppointmentsController::class, 'complete'])->name('appointments.complete');
    });

    // ============== Shift Report Routes (Authenticated Users) ==============
    Route::prefix('shift-reports')->group(function () {
        // فرم ثبت گزارش شیفت
        Route::get('/create', [ShiftReportController::class, 'create'])->name('shift-reports.create');
        
        // ثبت شروع شیفت
        Route::post('/start', [ShiftReportController::class, 'startShift'])->name('shift-reports.start');
        
        // ثبت پایان شیفت
        Route::post('/end', [ShiftReportController::class, 'endShift'])->name('shift-reports.end');
        
        // مشاهده گزارش‌های من
        Route::get('/my', [ShiftReportController::class, 'myReports'])->name('shift-reports.my');
        
        // جزئیات گزارش
        Route::get('/{id}', [ShiftReportController::class, 'show'])->name('shift-reports.show');
    });

    // ============== Shift Report Management Routes (Staff only) ==============
    Route::prefix('staff/shift-reports')->middleware(['role:employee|admin'])->group(function () {
        // مدیریت گزارش‌ها
        Route::get('/', [ShiftReportController::class, 'index'])->name('shift-reports.manage');
        
        // تأیید گزارش
        Route::post('/verify', [ShiftReportController::class, 'verify'])->name('shift-reports.verify');
    });

    // ============== Employee Routes (Staff only) ==============
    Route::prefix('employee')->middleware(['role:employee|admin'])->group(function () {
        // داشبورد پرسنل
        Route::get('/', [EmployeeController::class, 'index'])->name('employee.index');
        // ====== Supplier Management ======
        Route::prefix('supplier')->group(function () {
            Route::post('/create', [SupplierController::class, 'createSupplier'])->name('create-supplier');
            Route::get('/delete/{id}', [SupplierController::class, 'deleteSupplier'])->name('delete-supplier');
            Route::post('/edit/{id}', [SupplierController::class, 'editSupplier'])->name('edit-supplier');
        });
        
        // ====== Brand Management ======
        Route::prefix('brand')->group(function () {
            Route::post('/create', [BrandController::class, 'createBrand'])->name('create-brand');
            Route::get('/delete/{id}', [BrandController::class, 'deleteBrand'])->name('delete-brand');
            Route::post('/edit/{id}', [BrandController::class, 'editBrand'])->name('edit-brand');
        });
    });
});