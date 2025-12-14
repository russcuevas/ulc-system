<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admins;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admins::create([
            'fullname' => 'Admin',
            'email' => 'russelcuevas0@gmail.com',
            'password' => Hash::make('123456789'),
            'phone' => '09123456789',
            'gender' => 'Male',
            'status' => 'verified',
            'created_by' => 'Russel Vincent Cuevas'
        ]);
    }
}
