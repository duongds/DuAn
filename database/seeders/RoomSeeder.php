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
        $category = [
            ['name' => 'phong 1'],
            ['name' => 'phong 2'],
            ['name' => 'phong 3'],
            ['name' => 'phong 4']
        ];

        DB::table('rooms')->insert($category);
    }
}
