<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $room = [
            [
                'name' => 'Phong so 1',
                'seats' => [json_encode(array('hang' => 'D','cot' => 4,'status' => 1,'tpye' => 'normal')),json_encode(array('hang' => 'D', 'cot' => 4, 'status' => 1, 'tpye' => 'normal')),
                ]
            ]
        ];
        DB::table('rooms')->insert($room);
    }
}
