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
                'director' => 'Choi 1',
                'actor' => 'Choi 2, Choi 3',
                'duration' => '2:00:00',
                'like' => '123',
                'film_description' => 'ABCDEFGH',
                'film_status' => 1
            ],
            [
                'film_name' => 'Raya và rồng thần cuối cùng',
                'director' => 'Choi 1',
                'actor' => 'Choi 2, Choi 3',
                'poster' => '/storage/image/selection/2.jpg',
                'duration' => '2:00:00',
                'like' => '123',
                'film_description' => 'ABCDEFGH',
                'film_status' => 1
            ],
            [
                'film_name' => 'Chaos King hành trình hỗn loạn',
                'director' => 'Choi 1',
                'actor' => 'Choi 2, Choi 3',
                'poster' => '/storage/image/selection/3.jpg',
                'duration' => '2:00:00',
                'like' => '123',
                'film_description' => 'ABCDEFGH',
                'film_status' => 1
            ],
            [
                'film_name' => 'Godzila đại chiến Kong',
                'director' => 'Choi 1',
                'actor' => 'Choi 2, Choi 3',
                'poster' => '/storage/image/selection/4.jpg',
                'duration' => '2:00:00',
                'like' => '123',
                'film_description' => 'ABCDEFGH',
                'film_status' => 1
            ],
            [
                'film_name' => 'Song Xong',
                'director' => 'Choi 1',
                'actor' => 'Choi 2, Choi 3',
                'poster' => '/storage/image/selection/5.jpg',
                'duration' => '2:00:00',
                'like' => '123',
                'film_description' => 'ABCDEFGH',
                'film_status' => 1
            ],
            [
                'film_name' => 'Ối dời ơi là do bạn chưa chơi đồ đấy!',
                'director' => 'Choi 1',
                'actor' => 'Choi 2, Choi 3',
                'poster' => '/storage/image/selection/6.jpg',
                'duration' => '2:00:00',
                'like' => '123',
                'film_description' => 'ABCDEFGH',
                'film_status' => 1
            ],
            [
                'film_name' => 'Harry Porter và bình thuốc lắc',
                'director' => 'Choi 1',
                'actor' => 'Choi 2, Choi 3',
                'poster' => '/storage/image/selection/7.jpg',
                'duration' => '2:00:00',
                'like' => '123',
                'film_description' => 'ABCDEFGH',
                'film_status' => 1
            ],
            [
                'film_name' => 'Tàu nhanh không em ?',
                'director' => 'Choi 1',
                'actor' => 'Choi 2, Choi 3',
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
