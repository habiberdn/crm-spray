<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'SUSI ASTUTI',
                'avatar' => 'images/avatar-default.svg',
                'occupation' => 'PENGUSAHA',
                'bank_account' => 'SUSI ASTUTI',
                'bank_name' => 'BRI',
                'bank_account_number' => '5469-01-004554-53-7',
                'email' => 'susiastuti3077@gmail.com',
                'role' => 'admin',
                'password' => '$2y$10$3fhlt/rM8JMUjDamIhmW1O.QOJVAtK8mMVsoukUAcVeL/2gwNfpzG',
               
            ],
        ]);
    }
}
