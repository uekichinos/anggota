<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'              => 'Administrator',
            'username'          => 'administrator',
            'email'             => 'admin@localhost.com',
            'password'          => Hash::make('Password123'),
            'contactno'         => '01234567890',
            'memberno'          => '0000000000',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'email_verified_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
