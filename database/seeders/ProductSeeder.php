<?php


namespace Database\Seeders;


use App\Utils\CommonUtils;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $user = [
            [
                'film_name' => 'Bố già',
                'poster' => '/storage/image/selection/1.jpg',
                'duration' => '2:00:00',
                'like' => '123',
                'film_description' => 'ABCDEFGH',
                'film_status' => 1
            ],
            [
                'film_name' => 'Raya và rồng thần cuối cùng',
//                'category' => [CommonUtils::isFantasy, CommonUtils::isAnimation, CommonUtils::isMystery],
                // 'category' => json_encode(['category' => CommonUtils::isDrama, 'category' => CommonUtils::isComedy], true),
                'poster' => '/storage/image/selection/2.jpg',
                'duration' => '2:00:00',
                'like' => '123',
                'film_description' => 'ABCDEFGH',
                'film_status' => 1
            ],
            [
                'film_name' => 'Chaos King hành trình hỗn loạn',
//                'category' => [CommonUtils::isAction, CommonUtils::isMystery, CommonUtils::isHorror],
                // 'category' => json_encode(['category' => CommonUtils::isDrama, 'category' => CommonUtils::isComedy], true),
                'poster' => '/storage/image/selection/3.jpg',
                'duration' => '2:00:00',
                'like' => '123',
                'film_description' => 'ABCDEFGH',
                'film_status' => 1
            ],
            [
                'film_name' => 'Godzila đại chiến Kong',
//                'category' => [CommonUtils::isAction, CommonUtils::isMystery],
                // 'category' => json_encode(['category' => CommonUtils::isDrama, 'category' => CommonUtils::isComedy], true),
                'poster' => '/storage/image/selection/4.jpg',
                'duration' => '2:00:00',
                'like' => '123',
                'film_description' => 'ABCDEFGH',
                'film_status' => 1
            ],
            [
                'film_name' => 'Song Xong',
//                'category' => [CommonUtils::isMystery, CommonUtils::isThriller, CommonUtils::isHorror],
                // 'category' => json_encode(['category' => [CommonUtils::isDrama,CommonUtils::isComedy ]], true),
                'poster' => '/storage/image/selection/5.jpg',
                'duration' => '2:00:00',
                'like' => '123',
                'film_description' => 'ABCDEFGH',
                'film_status' => 1
            ],
            [
                'film_name' => 'Ối dời ơi là do bạn chưa chơi đồ đấy!',
//                'category' => [CommonUtils::isAnimation, CommonUtils::isComedy],
                // 'category' => json_encode(['category' => CommonUtils::isDrama, 'category' => CommonUtils::isComedy], true),
                'poster' => '/storage/image/selection/6.jpg',
                'duration' => '2:00:00',
                'like' => '123',
                'film_description' => 'ABCDEFGH',
                'film_status' => 1
            ],
            [
                'film_name' => 'Harry Porter và bình thuốc lắc',
//                'category' => [CommonUtils::isAction, CommonUtils::isThriller, CommonUtils::isFantasy],
                // 'category' => json_encode(['category' => CommonUtils::isDrama, 'category' => CommonUtils::isComedy], true),
                'poster' => '/storage/image/selection/7.jpg',
                'duration' => '2:00:00',
                'like' => '123',
                'film_description' => 'ABCDEFGH',
                'film_status' => 1
            ],
            [
                'film_name' => 'Tàu nhanh không em ?',
//                'category' => [CommonUtils::isThriller, CommonUtils::isDrama],
                // 'category' => json_encode(['category' => CommonUtils::isDrama, 'category' => CommonUtils::isComedy], true),
                'poster' => '/storage/image/selection/8.jpg',
                'duration' => '2:00:00',
                'like' => '123',
                'film_description' => 'ABCDEFGH',
                'film_status' => 1
            ],
        ];

        DB::table('products')->insert($user);
    }

}
