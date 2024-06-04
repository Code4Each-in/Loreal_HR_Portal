<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::truncate();
        $roles = [
            [
                'name'     => "Admin Access",
                'role_id' => 1
            ],
            [
                'name'     => "HR Controller Access",
                'role_id' => 2
            ],
            [
                'name'     => "HRBP Access",
                'role_id' => 3
            ],
            [
                'name'     => "Sales Planning Access",
                'role_id' => 4
            ],
            [
                'name'     => "IT Access",
                'role_id' => 5
            ],
            [
                'name'     => "Employee Access",
                'role_id' => 6
            ]

        ];
    
        DB::table('roles')->insert($roles);

    }
}
