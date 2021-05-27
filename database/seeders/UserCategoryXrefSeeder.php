<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserCategoryXrefSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mapping = [
            [
                'user_id' => 1,
                'category_id' => 0,
                'count'=>1
            ],
            [
                'user_id' => 1,
                'category_id' => 1,
                'count'=>1
            ],
            [
                'user_id' => 2,
                'category_id' => 1,
                'count'=>1
            ],
            [
                'user_id' => 2,
                'category_id' => 0,
                'count'=>1
            ],
            [
                'user_id' => 2,
                'category_id' => 3,
                'count'=>1
            ],
            [
                'user_id' => 4,
                'category_id' => 1,
                'count'=>1
            ],
            [
                'user_id' => 5,
                'category_id' => 1,
                'count'=>1
            ],
            [
                'user_id' => 5,
                'category_id' => 0,
                'count'=>1
            ],
            [
                'user_id' => 4,
                'category_id' => 3,
                'count'=>1
            ],
            [
                'user_id' => 5,
                'category_id' => 5,
                'count'=>1
            ],
            [
                'user_id' => 1,
                'category_id' => 6,
                'count'=>1
            ],
        ];
        DB::table('user_category_xref')->insert($mapping);
    }
}
