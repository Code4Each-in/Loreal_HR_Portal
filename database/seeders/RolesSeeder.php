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
                'name'     => "Super Admin",
                'role_id' => 1
            ],
            [
                'name'     => "Admin",
                'role_id' => 2
            ],
            [
                'name'     => "Manager",
                'role_id' => 3
            ]
        ];
    
        DB::table('roles')->insert($roles);

    }
}
