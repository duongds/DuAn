<?php


namespace Database\Seeders;


use App\Utils\CommonUtils;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $category = [
            ['name' => CommonUtils::isComedy],
            ['name' => CommonUtils::isDrama],
            ['name' => CommonUtils::isFantasy],
            ['name' => CommonUtils::isHorror],
            ['name' => CommonUtils::isRomance],
            ['name' => CommonUtils::isMystery],
            ['name' => CommonUtils::isThriller],
            ['name' => CommonUtils::isAction],
            ['name' => CommonUtils::isAnimation],
        ];

        DB::table('category')->insert($category);
    }

}
