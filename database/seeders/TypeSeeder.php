<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Type::truncate();
        $roles = [
            [
                'name'     => "Portal Employee"
            ],

            [
                'name'     => "Employee"
            ]
        ];
    
        DB::table('types')->insert($roles);
    }
}
