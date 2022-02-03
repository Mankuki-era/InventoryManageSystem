<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
            'name' => 'SASAKI KENSHIN',
            'number' => 90792,
            'email' => '18ec053@ms.dendai.ac.jp',
            'password' => Hash::make('sasaking'),
            'role' => 'NIGHTTIME',
            'admin' => 'assignment',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
