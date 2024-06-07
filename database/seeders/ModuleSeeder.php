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
            ],
            [
                'page_id' => 2,
                'module_name' => "Listing",
                'route_name' => "allsalaryHead",

            ],
            [
                'page_id' => 3,
                'module_name' => "Listing",
                'route_name' => "allBasicGrade",
            ],
            [
                'page_id' => 4,
                'module_name' => "Listing",
                'route_name' => "allBasicGradeSalary",
            ],
            [
                'page_id' => 5,
                'module_name' => "Listing",
                'route_name' => "emp_listing",
            ],
        ]);
    }
}
