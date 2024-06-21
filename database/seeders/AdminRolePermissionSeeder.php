<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RolePermission; 

class AdminRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          // Delete existing records with role_id = 1
        RolePermission::where('role_id', 1)->delete();
        RolePermission::insert([
            [
                'role_id' => 1,
                'module_id' => 1 
            ],
            [
                'role_id' => 1,
                'module_id' => 2

            ],
            [
                'role_id' => 1,
                'module_id' => 3
            ],
            [
               'role_id' => 1,
                'module_id' => 4
            ],
            [
                'role_id' => 1,
                'module_id' => 5
            ],
            [
               'role_id' => 1,
                'module_id' => 6 
            ],
            [
                'role_id' => 1,
                'module_id' => 7 
            ],
            [
                'role_id' => 1,
                'module_id' => 8
            ],
        ]);
    }
}
