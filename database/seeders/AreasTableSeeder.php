<?php

namespace Database\Seeders;

use App\Models\Areas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Areas::create([
            'area_name' => 'Area 1',
        ]);

        Areas::create([
            'area_name' => 'Area 2',
        ]);

        
        Areas::create([
            'area_name' => 'Area 3',
        ]);

        
        Areas::create([
            'area_name' => 'Area 4',
        ]);
        
        Areas::create([
            'area_name' => 'Area 5',
        ]);
        
        Areas::create([
            'area_name' => 'Area 6',
        ]);
        
        Areas::create([
            'area_name' => 'Area 7',
        ]);

        Areas::create([
            'area_name' => 'Area 8',
        ]);

    }
}
