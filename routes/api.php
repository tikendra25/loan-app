<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\API\LoanRequestController;
use App\Http\Controllers\API\PaymentControler;
use App\Http\Controllers\API\Admin\LoansController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', RegisterController::class)->name('register');
Route::post('login', [LoginController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
	
	Route::middleware('role:user')->group(function () {
		Route::post('loanrequest', LoanRequestController::class)->name('loan.request');
		Route::post('emi/payment', PaymentControler::class)->name('emi.payment');	
		Route::get('userloan', UsersController::class)->name('user.loan');		
	});

	Route::middleware('role:admin')->prefix('admin')->group(function () {
		Route::get('loans', [LoansController::class, 'loans'])->name('loans');
		Route::post('loanapproveandreject', [LoansController::class, 'loanapproveandreject'])->name('loanapproveandreject');
	});
	
});