<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InformationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('informations')->insert([
            [
            'perpage' => 10,
            'currentPage' => 1,
            'first_category' => null,
            'second_category' => null,
            'third_category' => null,
            'first_search' => null,
            'second_search' => null,
            'user_id' => null,
            'admin_pass' => Hash::make('clab_asp'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
