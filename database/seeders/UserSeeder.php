<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                'name'=>'duong1',
                'email'=>'buiduong2gmail.com',
                'phone'=>'3045797845',
                'address'=>'hanoi',
                'city'=>'ha noi',
                'role'=>'1',
                'password'=>'duong'
            ]
        );
    }
}
