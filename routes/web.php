<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\SuccessFactor;
use App\Http\Controllers\BasicGradeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GradeSalaryMasterController;


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
    Route::get('/master_salary_head', [SalaryController::class, 'index'])->name('salaryHead');
    Route::post('/salaryHead', [SalaryController::class, 'store']);
    Route::get('/salary_head_listing', [SalaryController::class, 'allsalaryHead'])->name('allsalaryHead');
    Route::get('/edit_salary_head/{id}', [SalaryController::class, 'edit_salary_head']);
    Route::post('/update_salary_head/{id}', [SalaryController::class, 'update_salary_head']);
    Route::post('/delete_sal_head', [SalaryController::class, 'delete_sal_head']);
    // End salary Head

    // Basic with grade pay

    Route::get('/create_grade', [BasicGradeController::class, 'index']);
    Route::get('/redirectURL', [BasicGradeController::class, 'redirectURL']);
    Route::post('/storegrade', [BasicGradeController::class, 'store']);
    Route::get('/grade_listing', [BasicGradeController::class, 'show'])->name('allBasicGrade');
    Route::post('/editBasicGrade', [BasicGradeController::class, 'editBasicGrade']);
    Route::post('/updateBasicGrade', [BasicGradeController::class, 'update']);
    Route::post('/deleteBasicGrade', [BasicGradeController::class, 'destroy']);


     // End Basic with grade pay

     // Employee Route
     Route::get('/emp_listing', [EmployeeController::class, 'index']);
     Route::post('/get_emp_data', [EmployeeController::class, 'emp_data']);
     // End employee route

    // End Basic with grade pay
    Route::get('/users', [UsersController::class, 'showListing'])->name('user.listing');
    Route::post('/users/edit', [UsersController::class, 'getUserById'])->name('user.get');
    Route::post('/users/update', [UsersController::class, 'update'])->name('user.update');
    Route::delete('/users/delete', [UsersController::class, 'destroy'])->name('user.destroy');
    Route::post('/users/change-password', [UsersController::class, 'changePassword'])->name('user.change-password');
    Route::get('/toggle-user-status', [UsersController::class, 'toggleStatus'])->name('toggle-user-status');

    Route::get('/basic_grade', [GradeSalaryMasterController::class, 'index'])->name('basic.grade');
    Route::post('/grade_salary_master', [GradeSalaryMasterController::class, 'store_grade']);
    Route::get('/basic_grade_salary_master_listing', [GradeSalaryMasterController::class, 'allBasicGradeSalary'])->name('allBasicGradeSalary');
    Route::get('/edit_basic_salary/{id}', [GradeSalaryMasterController::class, 'edit_basic_salary']);
    Route::post('/update_basic_salary/{id}', [GradeSalaryMasterController::class, 'update_basic_salary']);
    Route::post('/delete_basic_sal', [GradeSalaryMasterController::class, 'delete_basic_sal']);
 });


// Route::group(['middleware' => ['auth']], function () {
// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// });
    //Route for register
    Route::get('/registration', [UsersController::class, 'registration'])->name('register-user');
    Route::post('/register', [UsersController::class, 'register'])->name('user.create');

    // Success factor API
    // Sign on
        Route::get('/auth/azure', [SuccessFactor::class, 'signin']);
    // Reply  urls
        Route::get('/auth/azure/callback', [SuccessFactor::class, 'AppID']);
     //App ID URI
        Route::get('/azure_app_id', [SuccessFactor::class, 'HomePage']);
     // Homepage
       // Route::get('/ ', [SuccessFactor::class, 'LogOut ']);
    //Logout
       // Route::get('/successlogout', [SuccessFactor::class, 'Termsofservice']);
     // Terms of service url
        Route::get('/terms_of_service', [SuccessFactor::class, 'Privacystatement']);
     // Privacy statement
        Route::get('/privacy_statement', [SuccessFactor::class, 'Privacystatement']);

    //End Success factor API




    // Route::post('/users/{id}/activate', [UsersController::class, 'activateUser'])->name('user.activate');

    // Route::post('/users/{id}/deactivate', [UsersController::class, 'deactivateUser'])->name('user.deactivate');
