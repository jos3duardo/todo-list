<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Administrador',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'image' => 'default.png',
                'created_at' => now()
            ],
            [
                'name' => 'José Eduardo',
                'username' => 'jos3duardo',
                'email' => 'jos3duardolopes@gmail.com',
                'password' => Hash::make('password'),
                'image' => 'default.png',
                'created_at' => now()
            ],
        ];

        DB::table('users')->insert($data);
    }
}
