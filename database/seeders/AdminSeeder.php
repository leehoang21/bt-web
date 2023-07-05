<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $data = [

            'name' => 'Admin',
            'user_name' => 'admin',
            'email' => 'hh@gmail.com',
            'password' => bcrypt('123456'),
            'remember_token' => '12345456'
        ];
        \App\Models\Admin::create($data);

    }
}
