<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'password' => Hash::make('12345'),
            'type' => 1,
            'email' => 'admin@gmail.com',
            'msv' => 0,
            'class' => 0,
            'faculty' => 0,
        ]);
    }
}
