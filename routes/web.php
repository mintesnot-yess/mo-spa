<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FirebaseAuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\StafUserController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/test', [AdminController::class, 'test']);
Route::get('/sendNotification/firbase', [FirebaseAuthController::class, 'sendNotification']);
Route::middleware(['web'])->group(function () {
    Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/admin/login/post', [AdminController::class, 'store'])->name('admin.login.store');
    Route::middleware('staff')->prefix('admin')->group(function () {
        Route::get('/rolepermission', [RolePermissionController::class, 'index'])->name('rolepermission');
        Route::get('/assignpermission/{id}', [RolePermissionController::class, 'assignPermission'])->name('assignPermission');
        Route::post('/assignRolepermission/{id}', [RolePermissionController::class, 'assignRolePermission'])->name('assignRolePermission');
        // Dashboard

        Route::get('/test/firbase', [FirebaseAuthController::class, 'test_firebase']);
        Route::post('/store_fcm', [FirebaseAuthController::class, 'store_fcm']);
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::post('/notifications/mark-all-read', [AdminController::class, 'markAllRead'])
            ->name('notifications.markAllRead');

        // roles
        // Route::get('/role', [RoleController::class, 'index'])->name('role');
        Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
        Route::post('/role/store', [RoleController::class, 'store'])->name('role.store');
        Route::get('/role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
        Route::post('/role/update/{id}', [RoleController::class, 'update'])->name('role.update');
        Route::delete('/role/delete/{id}', [RoleController::class, 'delete'])->name('role.delete');

        // client
        Route::get('/client', [EmployeeController::class, 'client_index'])->name('client');
        Route::get('/client/create', [EmployeeController::class, 'client_create'])->name('client.create');
        Route::post('/client/create/store', [EmployeeController::class, 'client_store'])->name('client.store');
        Route::get('/client/edit/{id}', [EmployeeController::class, 'client_edit'])->name('client.edit');
        Route::post('/client/update/{id}', [EmployeeController::class, 'client_update'])->name('client.update');
        Route::delete('/client/delete/{id}', [EmployeeController::class, 'client_destroy'])->name('client.delete');
        Route::post('/client/update-status', [EmployeeController::class, 'updateStatus'])->name('client.updateStatus');
        Route::get('/client/data', [EmployeeController::class, 'getClient'])->name('client.data');

        // employee
        Route::get('/employee', [EmployeeController::class, 'index'])->name('employee');
        Route::get('/employee/create', [EmployeeController::class, 'create'])->name('employee.create');
        Route::post('/employee/create/store', [EmployeeController::class, 'store'])->name('employee.store');
        Route::get('/employee/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
        Route::post('/employee/update/{id}', [EmployeeController::class, 'update'])->name('employee.update');
        Route::delete('/employee/delete/{id}', [EmployeeController::class, 'destroy'])->name('employee.delete');
        Route::post('/employee/update-status', [EmployeeController::class, 'empupdateStatus'])->name('employee.updateStatus');

        // Service
        Route::get('/service', [ServiceController::class, 'index'])->name('service');
        Route::get('/service/create', [ServiceController::class, 'create'])->name('service.create');
        Route::post('/service/create/store', [ServiceController::class, 'store'])->name('service.store');
        Route::get('/service/edit/{id}', [ServiceController::class, 'edit'])->name('service.edit');
        Route::post('/service/update/{id}', [ServiceController::class, 'update'])->name('service.update');
        Route::delete('/service/delete/{id}', [ServiceController::class, 'destroy'])->name('service.delete');
        Route::post('/service/update-status', [ServiceController::class, 'updateStatus'])->name('service.updateStatus');
        Route::post('/service/complate', [ServiceController::class, 'complateServeice'])->name('service.complate');

        // category
        Route::get('/category', [CategoryController::class, 'index'])->name('category');
        Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/category/create/store', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.delete');

        // Branch
        Route::get('/branch', [ServiceController::class, 'branch_index'])->name('branch');
        Route::post('/branch/create/store', [ServiceController::class, 'branch_store'])->name('branch.store');
        Route::post('/branch/update', [ServiceController::class, 'branch_update'])->name('branch.update');
        Route::delete('/branch/delete/{id}', [ServiceController::class, 'branch_destroy'])->name('branch.delete');

        // Items
        Route::get('/item', [ServiceController::class, 'item_index'])->name('item');
        Route::post('/item/create/store', [ServiceController::class, 'item_store'])->name('item.store');
        Route::post('/item/update', [ServiceController::class, 'item_update'])->name('item.update');
        Route::delete('/item/delete/{id}', [ServiceController::class, 'item_destroy'])->name('item.delete');


        //Setting
        Route::get('/setting', [SettingController::class, 'setting'])->name('setting.index');
        Route::post('/setting/update/profile', [SettingController::class, 'update_profile'])->name('setting.update.profile');
        Route::post('/setting/update/password', [SettingController::class, 'update_password'])->name('setting.update.password');

        Route::get('/pending/transaction', [TransactionController::class, 'pending_index'])->name('pendingTransaction');
        Route::post('/pending/transaction/show', [TransactionController::class, 'pending_show'])->name('pendingTransaction.show');
        Route::delete('/transactions/{id}/delete', [TransactionController::class, 'destroy']);
        Route::post('/transactions/{id}/update-is-new', [TransactionController::class, 'updateIsNew']);

        Route::get('/complated/transaction', [TransactionController::class, 'index'])->name('complatedTransaction');
        Route::post('/complated/transaction/show', [TransactionController::class, 'show'])->name('complatedTransaction.show');

        // Customer
        // Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');




        // Staff Users
        Route::get('/staff', [StafUserController::class, 'staff'])->name('staff.index');
        Route::get('/staff/create', [StafUserController::class, 'staff_create'])->name('staff.create');
        Route::post('/staff/store', [StafUserController::class, 'staff_store'])->name('staff.store');
        Route::post('/employee/touser/store', [StafUserController::class, 'user_from_employee'])->name('empToUser.store');
        Route::get('/staff/edit/{id}', [StafUserController::class, 'staff_edit'])->name('staff.edit');
        Route::post('/staff/update/{id}', [StafUserController::class, 'staff_update'])->name('staff.update');
        Route::delete('/staff/delete/{id}', [StafUserController::class, 'staff_delete'])->name('staff.delete');
        Route::post('/staff/update-status', [StafUserController::class, 'updateStatus'])->name('user.updateStatus');

        Route::get('/report', [ReportController::class, 'index'])->name('report');
        Route::get('/report/show', [ReportController::class, 'show'])->name('report.show');

        Route::get('/report/service', [ReportController::class, 'service'])->name('byService');
        Route::get('/report/service/show', [ReportController::class, 'service_show'])->name('byService.show');

        Route::get('/report/employee', [ReportController::class, 'employee'])->name('byEmployee');
        Route::get('/report/employee/show', [ReportController::class, 'employee_show'])->name('byEmployee.show');

        Route::get('/report/customer', [ReportController::class, 'customer'])->name('byCustomer');
        Route::get('/report/customer/show', [ReportController::class, 'customer_show'])->name('byCustomer.show');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');





        //Attendance
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::post('/attendance/import', [AttendanceController::class, 'import'])->name('attendance.import');



        // for sms url
        Route::get('/sms', [SMSController::class, 'index'])->name('sms.index');


    });
});
require __DIR__ . '/auth.php';
