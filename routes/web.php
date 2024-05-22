<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SalaryController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------

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
    Route::get('/salart-head', [SalaryController::class, 'index'])->name('salaryHead');
    Route::post('/salaryHead', [SalaryController::class, 'store']);
 });


Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
    //Route for register
    Route::get('/registration', [UsersController::class, 'registration'])->name('register-user');
    Route::post('/register', [UsersController::class, 'register'])->name('user.create');

    Route::get('/users', [UsersController::class, 'showListing'])->name('user.listing');

    // Route::post('/users/{id}/activate', [UsersController::class, 'activateUser'])->name('user.activate');

    // Route::post('/users/{id}/deactivate', [UsersController::class, 'deactivateUser'])->name('user.deactivate');
    Route::post('/users/edit', [UsersController::class, 'getUserById'])->name('user.get');
    // Route::post('/users/update', [UsersController::class, 'update'])->name('user.update');
    Route::delete('/users/delete', [UsersController::class, 'destroy'])->name('user.destroy');
    Route::post('/users/change-password', [UsersController::class, 'changePassword'])->name('user.change-password');
