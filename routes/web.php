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
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EmployeeBenefitsController;


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

Route::group(['middleware' => ['auth']], function () {

   Route::middleware(['rolepermission'])->group(function () {

      Route::get('/users', [UsersController::class, 'showListing'])->name('user.listing');
      Route::get('/all_users', [UsersController::class, 'all_users'])->name('all_users');
      Route::get('/salary_head_listing', [SalaryController::class, 'allsalaryHead'])->name('allsalaryHead');
      Route::get('/grade_listing', [BasicGradeController::class, 'show'])->name('allBasicGrade');
      Route::get('/emp_listing', [EmployeeController::class, 'index'])->name('emp_listing');
      // Employye benefit
           Route::get('/employee_benefits', [EmployeeBenefitsController::class, 'index'])->name('employee_benefits.index');
      // End Employye benefit
       // Apply Benefits 
       Route::get('/apply_benefit', [EmployeeBenefitsController::class, 'apply_benefit'])->name('apply_benefit.index');
       // End apply Benefits 

       //Employee salary
       Route::get('/emp_salary', [EmployeeController::class, 'emp_salary'])->name('emp_salary');
       //End Employee salary
   });

   Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

   // change profile to admin
   Route::get('/profile_to_admin', [DashboardController::class, 'profile_to_admin'])->name('profile_to_admin');
   //change profile  to employee
   Route::get('/profile_to_emp', [DashboardController::class, 'profile_to_emp'])->name('profile_to_emp');
   // Salary  head   
   Route::get('/master_salary_head', [SalaryController::class, 'index'])->name('salaryHead');
   Route::post('/salaryHead', [SalaryController::class, 'store']);

   Route::get('/edit_salary_head/{id}', [SalaryController::class, 'edit_salary_head']);
   Route::post('/update_salary_head/{id}', [SalaryController::class, 'update_salary_head']);
   Route::post('/delete_sal_head', [SalaryController::class, 'delete_sal_head']);
   Route::get('/get_master_head_title', [SalaryController::class, 'get_master_head_title']);


   // End salary Head

   // Basic with grade pay

   Route::get('/create_grade', [BasicGradeController::class, 'index']);
   Route::get('/edit_grade/{id}', [BasicGradeController::class, 'edit_grade']);
   Route::get('/redirectURL', [BasicGradeController::class, 'redirectURL']);
   Route::post('/storegrade', [BasicGradeController::class, 'store']);
   //Route::get('/grade_listing', [BasicGradeController::class, 'show'])->name('allBasicGrade');
   Route::post('/editBasicGrade', [BasicGradeController::class, 'editBasicGrade']);
   Route::post('/updateBasicGrade', [BasicGradeController::class, 'update']);
   Route::post('/deleteBasicGrade', [BasicGradeController::class, 'destroy']);


   // End Basic with grade pay

   // Employee Route
   // Route::get('/emp_listing', [EmployeeController::class, 'index'])->name('emp_listing');
   Route::post('/get_emp_data', [EmployeeController::class, 'emp_data']);
   Route::get('/salary_struc/{id}', [EmployeeController::class, 'salary_struc']);
   // Route::get('/emp_salary', [EmployeeController::class, 'emp_salary'])->name('emp_salary');

   // End employee route

   // End Basic with grade pay
   //Route::get('/users', [UsersController::class, 'showListing'])->name('user.listing');
   Route::post('/users/edit', [UsersController::class, 'getUserById'])->name('user.get');
   Route::post('/users/update', [UsersController::class, 'update'])->name('user.update');
   Route::post('/users/delete', [UsersController::class, 'destroy'])->name('user.destroy');
   Route::post('/users/change-password', [UsersController::class, 'changePassword'])->name('user.change-password');
   Route::get('/toggle-user-status', [UsersController::class, 'toggleStatus'])->name('toggle-user-status');
   Route::post('/save_user', [UsersController::class, 'saveUser'])->name('user.save');

   Route::get('/basic_grade', [GradeSalaryMasterController::class, 'index'])->name('basic.grade');
   Route::post('/grade_salary_master', [GradeSalaryMasterController::class, 'store_grade']);
   Route::get('/basic_grade_salary_master_listing/{id?}', [GradeSalaryMasterController::class, 'allBasicGradeSalary'])->name('allBasicGradeSalary');
   Route::get('/edit_basic_salary/{id}', [GradeSalaryMasterController::class, 'edit_basic_salary']);
   Route::post('/update_basic_salary/{id}', [GradeSalaryMasterController::class, 'update_basic_salary']);
   Route::post('/delete_basic_sal', [GradeSalaryMasterController::class, 'delete_basic_sal']);
   Route::post('/get_grade_data', [GradeSalaryMasterController::class, 'get_grade_data']);

   //  Roles
   Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
   Route::post('/add/role', [RoleController::class, 'store'])->name('roles.add');
   Route::post('/edit/role', [RoleController::class, 'edit'])->name('roles.edit');
   Route::post('/update/role', [RoleController::class, 'update'])->name('roles.update');
   Route::post('/delete/role', [RoleController::class, 'destroy'])->name('roles.delete');
   //End roles 

   // Create Benefits
 //  Route::get('/employee_benefits', [EmployeeBenefitsController::class, 'index'])->name('employee_benefits.index');
   Route::get('/employee_benefits_create', [EmployeeBenefitsController::class, 'create'])->name('employee_benefits.create');
   Route::post('/employee_benefits_edit', [EmployeeBenefitsController::class, 'edit'])->name('employee_benefits.edit');
   Route::post('/employee_benefits_update', [EmployeeBenefitsController::class, 'update'])->name('employee_benefits.update');
   Route::post('/employee_benefits_store', [EmployeeBenefitsController::class, 'store'])->name('employee_benefits.store');
   Route::post('/employee_benefits/delete', [EmployeeBenefitsController::class, 'destroy'])->name('employee_benefits.delete');
   // End employee benefits

   // Apply Benefits 
      Route::post('/sbt_detail', [EmployeeBenefitsController::class, 'sbt_detail'])->name('sbt_detail.index');
   // End Apply Benefits

    // Show Benefit to admin for approvel
      Route::get('/benefits/approval', [EmployeeBenefitsController::class, 'approval_benefits'])->name('approval_benefits.index');
      Route::post('/approve_benefit', [EmployeeBenefitsController::class, 'approve_benefit'])->name('approve_benefit.index');
      Route::post('/reject_benefit', [EmployeeBenefitsController::class, 'reject_benefit'])->name('reject_benefit.index');
      
    // End Show Benefit to admin for approvel
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
Route::get('/permissions', [DashboardController::class, 'permissions']);

// Monthly salary of emp (Cron)
  Route::get('/monthly_salary', [EmployeeController::class, 'monthly_salary']);
// End monthly salary of emp

 // Salary slip
   Route::get('/salary_slip', [EmployeeController::class, 'salary_slip'])->name('salary_slip.index');

   // Download Salary Slip
   Route::get('/download_slip/{id}', [EmployeeController::class, 'download_slip'])->name('download_slip.index');
