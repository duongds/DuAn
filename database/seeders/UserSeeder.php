<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'duong',
                'email' => 'buiduong@gmail.com',
                'phone' => '3045797845',
                'address' => 'hanoi',
                'city' => 'ha noi',
                'role' => '1',
                'password' => Hash::make('abc@ABC1')
            ],
            [
                'name' => 'truong',
                'email' => 'ntta@gmail.com',
                'phone' => '3045797845',
                'address' => 'hanoi',
                'city' => 'ha noi',
                'role' => '1',
                'password' => Hash::make('abc@ABC1')
            ],
            [
                'name' => 'choi',
                'email' => 'choi@gmail.com',
                'phone' => '3045797845',
                'address' => 'hanoi',
                'city' => 'ha noi',
                'role' => '1',
                'password' => Hash::make('abc@ABC1')
            ],
            [
                'name' => 'cuong',
                'email' => 'cuong@gmail.com',
                'phone' => '3045797845',
                'address' => 'hanoi',
                'city' => 'ha noi',
                'role' => '1',
                'password' => Hash::make('abc@ABC1')
            ],
            [
                'name' => 'thuy',
                'email' => 'thuy@gmail.com',
                'phone' => '3045797845',
                'address' => 'hanoi',
                'city' => 'ha noi',
                'role' => '1',
                'password' => Hash::make('abc@ABC1')
            ],
        ];
        DB::table('users')->insert($user);
    }
}
