<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShowSeeder extends Seeder
{
    public function run()
    {
        $shows = [
            [
                'product_id' => 1,
                'room_id' => 1,
                'show_time' => '13:00:00',
                'show_date' => '2021-05-31'
            ],
            [
                'product_id' => 1,
                'room_id' => 2,
                'show_time' => '16:00:00',
                'show_date' => '2021-05-31'
            ],
            [
                'product_id' => 2,
                'room_id' => 2,
                'show_time' => '13:00:00',
                'show_date' => '2021-05-31'
            ],
            [
                'product_id' => 3,
                'room_id' => 3,
                'show_time' => '13:00:00',
                'show_date' => '2021-05-31'
            ],
        ];

        DB::table('shows')->insert($shows);
    }

}
