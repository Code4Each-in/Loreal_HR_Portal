<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();
        DB::table('users')->insert([
            'Fname'     => "Rohit",
            'Lname' => "Sharma",
            'Email' => "admin@gmail.com",
            'Phone' => "1234567890",
            'City'  => "Mohali",
            'State' => "Punjab",
            'zipcode'   =>   "160059",
            'address' => 'Mohali',
             'role_id' => '1',
            'password' => Hash::make('12345'),
        ]);
        
    }
}
