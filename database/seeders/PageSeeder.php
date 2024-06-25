<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Page::truncate();
        Page::insert([
            [
                'name' => "Users",
            ],
			[
                'name' => "Salary Head Listing",
            ],
            [
                'name' => "Grade",
            ],
            [
                'name' => "Employees",
            ],
            [
                'name' => "Salary",
            ],
            [
                'name' => "Salary Slips",
            ],
            [
                'name' => "Benefits",
            ],
            [
                'name' => "Apply Benefit",
            ],
            [
                'name' => "Roles",
            ]
        ]);
    }
}
