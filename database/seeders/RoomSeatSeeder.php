<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class RoomSeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data1 = Config::get('room_seats.room_1');
        DB::table('room_seat')->insert($data1);
        $data2 = Config::get('room_seats.room_2');
        DB::table('room_seat')->insert($data2);
        $data3 = Config::get('room_seats.room_3');
        DB::table('room_seat')->insert($data3);
        $data4 = Config::get('room_seats.room_4');
        DB::table('room_seat')->insert($data4);
    }
}
