<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Module;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Module::truncate();
        Module::insert([
            [
                'page_id' => 1,
                'module_name' => "Listing",
                'route_name' => "user.listing", 
                'text'  => "Users",
                'icon'  => "bi bi-person" 
            ],
            [
                'page_id' => 2,
                'module_name' => "Listing",
                'route_name' => "allsalaryHead",
                'text'  => "Salary Head Listing",
                'icon'  => "bi bi-menu-button-wide" 

            ],
            [
                'page_id' => 3,
                'module_name' => "Listing",
                'route_name' => "allBasicGrade",
                'text'  => "Grade Listing",
                'icon'  => "bi bi-layout-text-window-reverse" 
            ],
            [
                'page_id' => 4,
                'module_name' => "Listing",
                'route_name' => "emp_listing",
                'text'  => "Employee Listing",
                'icon'  => "bi bi-person" 
            ],
            [
                'page_id' => 5,
                'module_name' => "Listing",
                'route_name' => "roles.index",
                'text'  => "Roles",
                'icon'  => "bi bi-person" 
            ],
        ]);
    }
}
