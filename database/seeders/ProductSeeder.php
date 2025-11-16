<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Bantal Sofa 40 cm x 40 cm',
                'slug' => 'Bantal Sofa 40 cm x 40 cm',
                'cover' => 'product_covers/q7SMd0vFCHO4Mo7xacYSPJozdGspV3jfi5WaqwQx.jpg',
            ],
        ]);
    }
}
