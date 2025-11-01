<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/send-service-request', [ServiceController::class, 'send_service_request']);
    Route::get('/active-customers', [ClientController::class, 'activeCustomers']);
    Route::get('/services', [ServiceController::class, 'index']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/reception/active-customers', [ClientController::class, 'receptionactiveCustomers']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/notification', [AuthController::class, 'notification']);
    Route::post('/notifications/mark-all-read', [AuthController::class, 'markAllRead']);
    Route::post('/mark-prepared', [AuthController::class, 'markcomplated']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::get('/active-staff ', [ClientController::class, 'activeStaff']);
    Route::post('/profile/update', [AuthController::class, 'profile_update']);
    Route::get('/staff-customers', [ClientController::class, 'staffCustomers']);
    Route::get('/report', [ReportController::class, 'index']);
    Route::post('/activate-customer', [ClientController::class, 'activateCustomer']);
    Route::post('/scan-customer', [ClientController::class, 'scanCustomer']);
});