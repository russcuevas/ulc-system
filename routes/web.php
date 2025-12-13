<?php
// Auth Routes Controller Imports
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\auth\AccountVerifications;

// Admin Routes Controller Imports
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\AdminManagementController;
use App\Http\Controllers\admin\ClientsController;
use App\Http\Controllers\admin\AreasController;
use App\Http\Controllers\admin\PaymentsController;
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

// Mailer
Route::get('/admin/verify/{token}', [AccountVerifications::class, 'AdminAccountVerification'])->name('admin.verify');
Route::get('/admin/resend-verification/{admin}', [AccountVerifications::class, 'AdminAccountVerificationResend'])
    ->name('admin.verification.resend')
    ->middleware('signed');

// Admin Routes
Route::middleware('admin.auth')->group(function () {
    // Dashboard Routes
    Route::get('/admin/dashboard', [DashboardController::class, 'DashboardPage'])->name('admin.dashboard');
    Route::get('/admin/dashboard/chart-data', [DashboardController::class, 'getYearlyLoanData'])->name('dashboard.chart-data');
    // Admins Routes
    Route::resource('admin/admins', AdminManagementController::class);
    // Clients Routes
    Route::resource('admin/clients', ClientsController::class);
    // Areas Routes
    Route::resource('admin/areas', AreasController::class);
    // Payments Routes
    Route::get('admin/areas/{id}/clients/payments', [PaymentsController::class, 'Payments'])->name('areas.payments.show');
    Route::post('admin/areas/{id}/create', [PaymentsController::class, 'CreatePayments'])->name('areas.payments.create');
    Route::get('admin/areas/{area}/{reference_number}/view', [PaymentsController::class, 'ViewPayment'])
        ->name('areas.payments.view');
    Route::post('admin/areas/{area_id}/{reference_number}/update', [PaymentsController::class, 'UpdatePayment'])->name('areas.payments.update');
});




