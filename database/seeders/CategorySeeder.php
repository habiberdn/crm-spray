<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('categories')->insert([
            [
                'name' => 'Bantal',
                'slug' => 'bantal',
                'icon' => 'images/pillow.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Seprai',
                'slug' => 'seprai',
                'icon' => 'images/double-bed.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Lainnya',
                'slug' => 'lainnya',
                'icon' => 'images/other.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        
        ]);
    }
}
