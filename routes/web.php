<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;

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




 Route::match(['get', 'post'], '/', [LoginController::class, 'index']);
 Route::match(['get', 'post'], '/login', [LoginController::class, 'login'])->name('login');
 Route::get('/logout', [LoginController::class, 'logOut']);
 Route::get('/forgot-password', [LoginController::class, 'forgotPasswordView'])->name('forgot-password');
 Route::post('/forgot-password', [LoginController::class, 'forgotPassword'])->name('forgot.password');
 Route::get('/reset/password/{token}', [LoginController::class, 'resetPassword']);
 Route::post('/reset/password', [LoginController::class, 'submitResetPasswordForm'])->name('submit.reset.password'); 

 Route::group(['middleware' => ['auth']], function() {  
    Route::get('/dashboard', [DashboardController::class, 'index']);
 });

 



