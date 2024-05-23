<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\SuccessFactor;
use App\Http\Controllers\BasicGradeController;


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
    // Salary  head
    Route::get('/salart-head', [SalaryController::class, 'index'])->name('salaryHead');
    Route::post('/salaryHead', [SalaryController::class, 'store']);
    Route::get('/allsalaryHead', [SalaryController::class, 'allsalaryHead'])->name('allsalaryHead');
    Route::get('/edit_salary_head/{id}', [SalaryController::class, 'edit_salary_head']);
    Route::post('/update_salary_head/{id}', [SalaryController::class, 'update_salary_head']);
    Route::post('/delete_sal_head', [SalaryController::class, 'delete_sal_head']);
    // End salary Head

    // Basic with grade pay

    Route::get('/basicGrade', [BasicGradeController::class, 'index']);
    Route::get('/redirectURL', [BasicGradeController::class, 'redirectURL']);
    Route::post('/storegrade', [BasicGradeController::class, 'store']);
    Route::get('/allBasicGrade', [BasicGradeController::class, 'show'])->name('allBasicGrade');
    Route::post('/editBasicGrade', [BasicGradeController::class, 'editBasicGrade']);
    Route::post('/updateBasicGrade', [BasicGradeController::class, 'update']);
    Route::post('/deleteBasicGrade', [BasicGradeController::class, 'destroy']);

    // End Basic with grade pay
    Route::get('/users', [UsersController::class, 'showListing'])->name('user.listing');
    Route::post('/users/edit', [UsersController::class, 'getUserById'])->name('user.get');
    Route::post('/users/update', [UsersController::class, 'update'])->name('user.update');
    Route::delete('/users/delete', [UsersController::class, 'destroy'])->name('user.destroy');
    Route::post('/users/change-password', [UsersController::class, 'changePassword'])->name('user.change-password');
    Route::get('/toggle-user-status', [UsersController::class, 'toggleStatus'])->name('toggle-user-status');
 });


// Route::group(['middleware' => ['auth']], function () {
// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// });
    //Route for register
    Route::get('/registration', [UsersController::class, 'registration'])->name('register-user');
    Route::post('/register', [UsersController::class, 'register'])->name('user.create');

    // Success factor API
    Route::get('/succesFactor-signin', [SuccessFactor::class, 'signin']);
    Route::get('/succesFactor-AppID', [SuccessFactor::class, 'AppID']);
    Route::get('/succesFactor-HomePage', [SuccessFactor::class, 'HomePage']);
    Route::get('/succesFactor-LogOut ', [SuccessFactor::class, 'LogOut ']);
    Route::get('/succesFactor-Termsofservice ', [SuccessFactor::class, 'Termsofservice']);
    Route::get('/succesFactor-Privacystatement  ', [SuccessFactor::class, 'Privacystatement']);

    //End Success factor API




    // Route::post('/users/{id}/activate', [UsersController::class, 'activateUser'])->name('user.activate');

    // Route::post('/users/{id}/deactivate', [UsersController::class, 'deactivateUser'])->name('user.deactivate');
