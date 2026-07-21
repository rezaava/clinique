<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BrandController;
use App\Models\Brand;
use Illuminate\Support\Facades\Route;

// ================ Auth Routes ================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ================ Appointment Routes (Client) ================
Route::middleware('auth')->group(function () {
    // مشتری: درخواست نوبت جدید
    Route::get('/appointments/create', [AppointmentsController::class, 'create'])->name('appointments.create');
    Route::post('/appointments/store', [AppointmentsController::class, 'store'])->name('appointments.store');
    
    // مشتری: مشاهده نوبت‌های خود
    Route::get('/appointments/my', [AppointmentsController::class, 'myAppointments'])->name('appointments.my');
    
    // مشتری و پرسنل: مشاهده جزئیات نوبت
    Route::get('/appointments/{id}', [AppointmentsController::class, 'show'])->name('appointments.show');
    
    // مشتری و پرسنل: تاریخچه نوبت‌ها
    Route::get('/appointments/history/{userId?}', [AppointmentsController::class, 'history'])->name('appointments.history');
});

// ================ Appointment Management Routes (Staff only) ================
Route::prefix('/staff/appointments')->middleware(['auth', 'role:employee|admin'])->group(function () {
    // مدیریت نوبت‌ها (لیست درخواست‌ها)
    Route::get('/', [AppointmentsController::class, 'index'])->name('appointments.manage');
    
    // تأیید نوبت
    Route::post('/confirm', [AppointmentsController::class, 'confirm'])->name('appointments.confirm');
    
    // لغو نوبت
    Route::post('/cancel', [AppointmentsController::class, 'cancel'])->name('appointments.cancel');
    
    // تکمیل نوبت
    Route::post('/complete', [AppointmentsController::class, 'complete'])->name('appointments.complete');
});



// ================ Employee Routes ================
Route::prefix('/employee')->middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('employee.index');

    Route::prefix('/supplier')->group(function(){

    Route::post('/create', [SupplierController::class, 'createSupplier'])->name('create-supplier');
    Route::get('/delete/{id}', [SupplierController::class, 'deleteSupplier'])->name('delete-supplier');
    Route::post('/edit/{id}', [SupplierController::class, 'editSupplier'])->name('edit-supplier');
    });
    
    Route::prefix('/brand')->group(function(){
        Route::post('create', [BrandController::class, 'createBrand'])->name('create-brand');
        Route::get('/delete/{id}', [BrandController::class, 'deleteBrand'])->name('delete-brand');
        Route::post('/edit/{id}', [BrandController::class, 'editBrand'])->name('edit-brand');
    });


        
});


