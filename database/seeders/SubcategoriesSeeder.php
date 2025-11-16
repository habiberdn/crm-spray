<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SubcategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subcategories')->insert([
            [
                'name' => 'Seprai 200x200x30',
            ],
            [
                'name' => 'Seprai 180x200x30',
            ],
            [
                'name' => 'Seprai 160x200x30',
            ],
            [
                'name' => 'Seprai 120x200x30',
            ],
            [
                'name' => 'Seprai 100x200x30',
            ],
            [
                'name' => 'Seprai 90x190x25',
            ],
            [
                'name' => 'Bantal cinta ukuran 50x100',
            ],
            [
                'name' => 'Bantal kepala ukuran 50x70',
            ],
            [
                'name' => 'Bantal kursi ukuran 30x30 , 40x40',
            ],
            [
                'name' => 'Bantal imut 30x60',
            ],
            [
                'name' => 'Bantal gendang 30x60',
            ],
            [
                'name' => 'Mukenah dewasa jumbo 160cm',
            ],
            [
                'name' => 'Mukenah dewasa 140cm',
            ],
            [
                'name' => 'Mukenah anak SD 120cm',
            ],
            [
                'name' => 'Mukenah anak anak 80cm',
            ],
             [
                'name' => 'Seragam Sekolah',
            ],
                 [
                'name' => 'Deta dan Tangkuluang',
            ],
        ]);
    }
}
