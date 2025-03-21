<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StafUserController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;


Route::middleware(['web'])->group(function () {
    Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/admin/login/post', [AdminController::class, 'store'])->name('admin.login.store');
    Route::middleware('staff')->prefix('admin')->group(function () {
        Route::get('/rolepermission', [RolePermissionController::class, 'index'])->name('rolepermission');
        Route::get('/assignpermission/{id}', [RolePermissionController::class, 'assignPermission'])->name('assignPermission');
        Route::post('/assignRolepermission/{id}', [RolePermissionController::class, 'assignRolePermission'])->name('assignRolePermission');
        // Dashboard 
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

        // employee 
        Route::get('/employee', [EmployeeController::class, 'index'])->name('employee');
        Route::get('/employee/create', [EmployeeController::class, 'create'])->name('employee.create');
        Route::post('/employee/create/store', [EmployeeController::class, 'store'])->name('employee.store');
        Route::get('/employee/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
        Route::post('/employee/update/{id}', [EmployeeController::class, 'update'])->name('employee.update');
        Route::delete('/employee/delete/{id}', [EmployeeController::class, 'destroy'])->name('employee.delete');

        // Service 
        Route::get('/service', [ServiceController::class, 'index'])->name('service');
        Route::get('/service/create', [ServiceController::class, 'create'])->name('service.create');
        Route::post('/service/create/store', [ServiceController::class, 'store'])->name('service.store');
        Route::get('/service/edit/{id}', [ServiceController::class, 'edit'])->name('service.edit');
        Route::post('/service/update/{id}', [ServiceController::class, 'update'])->name('service.update');
        Route::delete('/service/delete/{id}', [ServiceController::class, 'destroy'])->name('service.delete');
        Route::post('/service/update-status', [ServiceController::class, 'updateStatus'])->name('service.updateStatus');

        // category 
        Route::get('/category', [CategoryController::class, 'index'])->name('category');
        Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/category/create/store', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.delete');

       
        //Setting
        Route::get('/setting', [SettingController::class, 'setting'])->name('setting.index');
        Route::post('/setting/update/profile', [SettingController::class, 'update_profile'])->name('setting.update.profile');
        Route::post('/setting/update/password', [SettingController::class, 'update_password'])->name('setting.update.password');

        Route::get('/pending/transaction', [TransactionController::class, 'pending_index'])->name('pendingTransaction');
        Route::post('/pending/transaction/show', [TransactionController::class, 'pending_show'])->name('pendingTransaction.show');
        
        Route::get('/complated/transaction', [TransactionController::class, 'index'])->name('complatedTransaction');
        Route::post('/complated/transaction/show', [TransactionController::class, 'show'])->name('complatedTransaction.show');
        
        // Customer
        // Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');

        // Staff Users
        Route::get('/staff', [StafUserController::class, 'staff'])->name('staff.index');
        Route::get('/staff/create', [StafUserController::class, 'staff_create'])->name('staff.create');
        Route::post('/staff/store', [StafUserController::class, 'staff_store'])->name('staff.store');
        Route::get('/staff/edit/{id}', [StafUserController::class, 'staff_edit'])->name('staff.edit');
        Route::post('/staff/update/{id}', [StafUserController::class, 'staff_update'])->name('staff.update');
        Route::delete('/staff/delete/{id}', [StafUserController::class, 'staff_delete'])->name('staff.delete');

        Route::get('/report', [ReportController::class, 'index'])->name('report');
        Route::post('/report/show', [ReportController::class, 'show'])->name('report.show');
        
        Route::get('/report/service', [ReportController::class, 'service'])->name('byService');
        Route::post('/report/service/show', [ReportController::class, 'service_show'])->name('byService.show');
        
        Route::get('/report/employee', [ReportController::class, 'employee'])->name('byEmployee');
        Route::post('/report/employee/show', [ReportController::class, 'employee_show'])->name('byEmployee.show');

        Route::get('/report/customer', [ReportController::class, 'customer'])->name('byCustomer');
        Route::post('/report/customer/show', [ReportController::class, 'customer_show'])->name('byCustomer.show');

        Route::get('/report/customer_type', [ReportController::class, 'customer_type'])->name('byCustomerType');
        Route::post('/report/customer_type/show', [ReportController::class, 'customer_type_show'])->name('byCustomerType.show');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});
require __DIR__ . '/auth.php';
