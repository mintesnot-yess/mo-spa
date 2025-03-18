<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;

use App\Http\Controllers\SettingController;
use App\Http\Controllers\StafUserController;
use App\Http\Controllers\VehicleController;
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

        // roles
        // Route::get('/role', [RoleController::class, 'index'])->name('role');
        Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
        Route::post('/role/store', [RoleController::class, 'store'])->name('role.store');
        Route::get('/role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
        Route::post('/role/update/{id}', [RoleController::class, 'update'])->name('role.update');
        Route::delete('/role/delete/{id}', [RoleController::class, 'delete'])->name('role.delete');

        // order
        Route::get('/order', [OrderController::class, 'index'])->name('order');
        Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
        Route::post('/order/create/store', [OrderController::class, 'store'])->name('order.store');
        Route::get('/order/edit/{id}', [OrderController::class, 'edit'])->name('order.edit');
        Route::post('/order/update/{id}', [OrderController::class, 'update'])->name('order.update');
        Route::get('/order/detail/{id}', [OrderController::class, 'detail'])->name('order.detail');
        Route::delete('/order/delete/{id}', [OrderController::class, 'destroy'])->name('order.delete');
        Route::post('/order/status/{id}', [OrderController::class, 'status'])->name('order.status');

        // paymentCollection
        Route::get('/paymentCollection', [PaymentController::class, 'index'])->name('paymentCollection');
        Route::get('/paymentCollection/create/{id}', [PaymentController::class, 'create'])->name('paymentCollection.create');
        Route::post('/paymentCollection/create/store', [PaymentController::class, 'store'])->name('paymentCollection.store');
        Route::get('/paymentCollection/edit/{id}/{paymentId}', [PaymentController::class, 'edit'])->name('paymentCollection.edit');
        Route::post('/paymentCollection/update/{id}', [PaymentController::class, 'update'])->name('paymentCollection.update');
        Route::delete('/paymentCollection/delete/{id}', [PaymentController::class, 'destroy'])->name('paymentCollection.delete');

        // commission
        Route::get('/commission', [CommissionController::class, 'index'])->name('commission');
        Route::get('/commission/create', [CommissionController::class, 'create'])->name('commission.create');
        Route::post('/commission/create/store', [CommissionController::class, 'store'])->name('commission.store');
        Route::get('/commission/edit/{id}', [CommissionController::class, 'edit'])->name('commission.edit');
        Route::post('/commission/update/{id}', [CommissionController::class, 'update'])->name('commission.update');
        Route::delete('/commission/delete/{id}', [CommissionController::class, 'destroy'])->name('commission.delete');

        // bank
        Route::get('/bank', [BankController::class, 'index'])->name('bank');
        Route::get('/bank/create', [BankController::class, 'create'])->name('bank.create');
        Route::post('/bank/create/store', [BankController::class, 'store'])->name('bank.store');
        Route::get('/bank/edit/{id}', [BankController::class, 'edit'])->name('bank.edit');
        Route::post('/bank/update/{id}', [BankController::class, 'update'])->name('bank.update');
        Route::delete('/bank/delete/{id}', [BankController::class, 'destroy'])->name('bank.delete');
        Route::get('/bank/{bankId}/accounts', [BankController::class, 'getAccounts'])->name('bank.getAccounts');


        // account
        Route::get('/bank/detail/{id}', [BankController::class, 'bank_detail'])->name('bank.detail');
        Route::post('/bank/account/create/store', [BankController::class, 'account_store'])->name('bank.account.store');
        Route::post('/bank/account/update/{id}', [BankController::class, 'account_update'])->name('bank.account.update');
        Route::delete('/bank/account/destroy/{id}', [BankController::class, 'account_destroy'])->name('bank.account.delete');
        
        // loadType
        Route::get('/loadType', [SettingController::class, 'loadType_index'])->name('loadType');
        Route::get('/loadType/create', [SettingController::class, 'loadType_create'])->name('loadType.create');
        Route::post('/loadType/create/store', [SettingController::class, 'loadType_store'])->name('loadType.store');
        Route::get('/loadType/edit/{id}', [SettingController::class, 'loadType_edit'])->name('loadType.edit');
        Route::post('/loadType/update/{id}', [SettingController::class, 'loadType_update'])->name('loadType.update');
        Route::delete('/loadType/delete/{id}', [SettingController::class, 'loadType_destroy'])->name('loadType.delete');

        // location
        Route::get('/location', [SettingController::class, 'location_index'])->name('location');
        Route::get('/location/create', [SettingController::class, 'location_create'])->name('location.create');
        Route::post('/location/create/store', [SettingController::class, 'location_store'])->name('location.store');
        Route::get('/location/edit/{id}', [SettingController::class, 'location_edit'])->name('location.edit');
        Route::post('/location/update/{id}', [SettingController::class, 'location_update'])->name('location.update');
        Route::delete('/location/delete/{id}', [SettingController::class, 'location_destroy'])->name('location.delete');

        // Vehicle
        Route::get('/Vehicle', [VehicleController::class, 'index'])->name('vehicle');
        Route::get('/Vehicle/create', [VehicleController::class, 'create'])->name('vehicle.create');
        Route::post('/Vehicle/create/store', [VehicleController::class, 'store'])->name('vehicle.store');
        Route::get('/Vehicle/edit/{id}', [VehicleController::class, 'edit'])->name('vehicle.edit');
        Route::post('/Vehicle/update/{id}', [VehicleController::class, 'update'])->name('vehicle.update');
        Route::get('/Vehicle/detail/{id}', [VehicleController::class, 'detail'])->name('vehicle.detail');
        Route::delete('/Vehicle/delete/{id}', [VehicleController::class, 'destroy'])->name('vehicle.delete');

        // client 
        Route::get('/client', [EmployeeController::class, 'client_index'])->name('client');
        Route::get('/client/create', [EmployeeController::class, 'client_create'])->name('client.create');
        Route::post('/client/create/store', [EmployeeController::class, 'client_store'])->name('client.store');
        Route::get('/client/edit/{id}', [EmployeeController::class, 'client_edit'])->name('client.edit');
        Route::post('/client/update/{id}', [EmployeeController::class, 'client_update'])->name('client.update');
        Route::delete('/client/delete/{id}', [EmployeeController::class, 'client_destroy'])->name('client.delete');

        // employee 
        Route::get('/employee', [EmployeeController::class, 'index'])->name('driver');
        Route::get('/employee/create', [EmployeeController::class, 'create'])->name('driver.create');
        Route::post('/employee/create/store', [EmployeeController::class, 'store'])->name('driver.store');
        Route::get('/employee/edit/{id}', [EmployeeController::class, 'edit'])->name('driver.edit');
        Route::post('/employee/update/{id}', [EmployeeController::class, 'update'])->name('driver.update');
        Route::delete('/employee/delete/{id}', [EmployeeController::class, 'destroy'])->name('driver.delete');

        // expense 
        Route::get('/expense', [ExpenseController::class, 'index'])->name('expense');
        Route::get('/expense/create', [ExpenseController::class, 'create'])->name('expense.create');
        Route::post('/expense/create/store', [ExpenseController::class, 'store'])->name('expense.store');
        Route::get('/expense/edit/{id}', [ExpenseController::class, 'edit'])->name('expense.edit');
        Route::post('/expense/update/{id}', [ExpenseController::class, 'update'])->name('expense.update');
        Route::delete('/expense/delete/{id}', [ExpenseController::class, 'destroy'])->name('expense.delete');

        // order expense 
        // Route::get('/order/expense', [ExpenseController::class, 'order_index'])->name('order.expense');
        Route::get('/order/expense/create/{id}', [ExpenseController::class, 'order_create'])->name('order.expense.create');
        Route::post('/order/expense/create/store', [ExpenseController::class, 'order_store'])->name('order.expense.store');
        Route::get('/order/expense/edit/{id}/{expenseId}', [ExpenseController::class, 'order_edit'])->name('order.expense.edit');
        Route::post('/order/expense/update/{id}', [ExpenseController::class, 'order_update'])->name('order.expense.update');
        Route::delete('/order/expense/delete/{id}', [ExpenseController::class, 'order_destroy'])->name('order.expense.delete');

        // expense Type
        Route::get('/expense/type', [ExpenseController::class, 'type_index'])->name('expenseType');
        Route::get('/expense/type/create', [ExpenseController::class, 'type_create'])->name('expenseType.create');
        Route::post('/expense/type/create/store', [ExpenseController::class, 'type_store'])->name('expenseType.store');
        Route::get('/expense/type/edit/{id}', [ExpenseController::class, 'type_edit'])->name('expenseType.edit');
        Route::post('/expense/type/update/{id}', [ExpenseController::class, 'type_update'])->name('expenseType.update');
        Route::delete('/expense/type/delete/{id}', [ExpenseController::class, 'type_destroy'])->name('expenseType.delete');

        //Setting
        Route::get('/setting', [SettingController::class, 'setting'])->name('setting.index');
        Route::post('/setting/update/profile', [SettingController::class, 'update_profile'])->name('setting.update.profile');
        Route::post('/setting/update/password', [SettingController::class, 'update_password'])->name('setting.update.password');

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
        
        Route::get('/ownVsprivate', [ReportController::class, 'ownVsprivate'])->name('ownVsprivate');
        Route::post('/ownVsprivate/show', [ReportController::class, 'ownVsprivate_show'])->name('ownVsprivate.show');
        
        Route::get('report/location', [ReportController::class, 'location'])->name('report.location');
        Route::post('report/location/show', [ReportController::class, 'location_show'])->name('report.location.show');

        Route::get('report/loadingType', [ReportController::class, 'loadingType'])->name('report.loadingType');
        Route::post('report/loadingType/show', [ReportController::class, 'loadingType_show'])->name('report.loadingType.show');

        Route::get('report/client', [ReportController::class, 'client'])->name('report.client');
        Route::post('report/client/show', [ReportController::class, 'client_show'])->name('report.client.show');

        Route::get('report/expenseType', [ReportController::class, 'expenseType'])->name('report.expenseType');
        Route::post('report/expenseType/show', [ReportController::class, 'expenseType_show'])->name('report.expenseType.show');

        Route::get('report/vehicle', [ReportController::class, 'vehicle'])->name('report.vehicle');
        Route::post('report/vehicle/show', [ReportController::class, 'vehicle_show'])->name('report.vehicle.show');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});
require __DIR__ . '/auth.php';
