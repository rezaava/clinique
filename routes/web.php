<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InventoryController;
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

    // ================ Inventory Routes ================
    Route::prefix('inventory')->group(function () {
        
        // ====== Consumables ======
        Route::prefix('consumables')->group(function () {
            Route::get('/', [InventoryController::class, 'consumablesIndex'])->name('inventory.consumables.index');
            Route::get('/create', [InventoryController::class, 'consumablesCreate'])->name('inventory.consumables.create');
            Route::post('/store', [InventoryController::class, 'consumablesStore'])->name('inventory.consumables.store');
            Route::get('/edit/{id}', [InventoryController::class, 'consumablesEdit'])->name('inventory.consumables.edit');
            Route::post('/update/{id}', [InventoryController::class, 'consumablesUpdate'])->name('inventory.consumables.update');
            Route::get('/delete/{id}', [InventoryController::class, 'consumablesDelete'])->name('inventory.consumables.delete');
        });
        
        // ====== Devices ======
        Route::prefix('devices')->group(function () {
            Route::get('/', [InventoryController::class, 'devicesIndex'])->name('inventory.devices.index');
            Route::get('/create', [InventoryController::class, 'devicesCreate'])->name('inventory.devices.create');
            Route::post('/store', [InventoryController::class, 'devicesStore'])->name('inventory.devices.store');
            Route::get('/edit/{id}', [InventoryController::class, 'devicesEdit'])->name('inventory.devices.edit');
            Route::post('/update/{id}', [InventoryController::class, 'devicesUpdate'])->name('inventory.devices.update');
            Route::get('/delete/{id}', [InventoryController::class, 'devicesDelete'])->name('inventory.devices.delete');
        });
        
        // ====== Parts ======
        Route::prefix('parts')->group(function () {
            Route::get('/', [InventoryController::class, 'partsIndex'])->name('inventory.parts.index');
            Route::get('/create', [InventoryController::class, 'partsCreate'])->name('inventory.parts.create');
            Route::post('/store', [InventoryController::class, 'partsStore'])->name('inventory.parts.store');
            Route::get('/edit/{id}', [InventoryController::class, 'partsEdit'])->name('inventory.parts.edit');
            Route::post('/update/{id}', [InventoryController::class, 'partsUpdate'])->name('inventory.parts.update');
            Route::get('/delete/{id}', [InventoryController::class, 'partsDelete'])->name('inventory.parts.delete');
        });
        
        // ====== Purchase Requests ======
        Route::prefix('purchases')->group(function () {
            Route::get('/', [InventoryController::class, 'purchaseRequestsIndex'])->name('inventory.purchases.index');
            Route::get('/create', [InventoryController::class, 'purchaseRequestsCreate'])->name('inventory.purchases.create');
            Route::post('/store', [InventoryController::class, 'purchaseRequestsStore'])->name('inventory.purchases.store');
            Route::post('/approve/{id}', [InventoryController::class, 'purchaseRequestsApprove'])->name('inventory.purchases.approve');
            Route::post('/reject/{id}', [InventoryController::class, 'purchaseRequestsReject'])->name('inventory.purchases.reject');
            Route::post('/receive/{id}', [InventoryController::class, 'purchaseRequestsReceive'])->name('inventory.purchases.receive');
        });
        
        // ====== Transactions ======
        Route::get('/transactions', [InventoryController::class, 'transactionsIndex'])->name('inventory.transactions.index');
        
        // ====== Maintenance ======
        Route::prefix('maintenance')->group(function () {
            Route::get('/', [InventoryController::class, 'maintenanceIndex'])->name('inventory.maintenance.index');
            Route::post('/store', [InventoryController::class, 'maintenanceStore'])->name('inventory.maintenance.store');
            Route::get('/show/{id}', [InventoryController::class, 'maintenanceShow'])->name('inventory.maintenance.show');
        });
    });
});