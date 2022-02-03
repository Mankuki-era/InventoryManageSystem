<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('carts')->truncate();
        DB::table('item_tag')->truncate();
        DB::table('users')->truncate();
        DB::table('items')->truncate();
        DB::table('tags')->truncate();
        DB::table('themas')->truncate();
        DB::table('informations')->truncate();
        DB::table('notifications')->truncate();

        // $this->call(ItemsTableSeeder::class);
        $this->call(InformationsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ThemasTableSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
