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
            'fullname' => 'Super Admin',
            'email' => 'superadmin@ulc.com',
            'password' => Hash::make('password123'),
            'phone' => '09123456789',
            'gender' => 'Male',
            'status' => 'verified',
        ]);

        Admins::create([
            'fullname' => 'Regular Admin',
            'email' => 'admin@ulc.com',
            'password' => Hash::make('admin123'),
            'phone' => '09876543210',
            'gender' => 'Female',
            'status' => 'verified',
        ]);
    }
}
