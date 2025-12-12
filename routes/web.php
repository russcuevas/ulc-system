<?php
// Auth Routes Controller Imports
use App\Http\Controllers\auth\AuthController;

// Admin Routes Controller Imports
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\AdminManagementController;
use App\Http\Controllers\admin\ClientsController;
use App\Http\Controllers\admin\AreasController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Auth Routes
Route::get('/forgot-password', [AuthController::class, 'ForgotPasswordPage'])->name('admin.forgot-password');
Route::get('/login', [AuthController::class, 'LoginPage'])->name('admin.login');
Route::post('/login-request', [AuthController::class, 'LoginRequest'])->name('admin.login-request');
Route::post('/logout', [AuthController::class, 'Logout'])->name('admin.logout');

Route::middleware('admin.auth')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'DashboardPage'])->name('admin.dashboard');
    Route::resource('admin/clients', ClientsController::class);
});

// Admin Routes
Route::resource('admin/admins', AdminManagementController::class);


// Areas Routes
Route::resource('admin/areas', AreasController::class);

// Areas Payments Routes
Route::get('admin/areas/{id}/clients/payments', [AreasController::class, 'Payments'])->name('areas.payments.show');
Route::post('admin/areas/{id}/create', [AreasController::class, 'CreatePayments'])->name('areas.payments.create');
Route::get('admin/areas/{area}/{reference_number}/view', [AreasController::class, 'ViewPayment'])
    ->name('areas.payments.view');
Route::post('admin/areas/{area_id}/{reference_number}/update', [AreasController::class, 'UpdatePayment'])->name('areas.payments.update');