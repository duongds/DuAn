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
                'film_trailer' => 'https://www.youtube.com/watch?v=jluSu8Rw6YE',
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
                'film_trailer' => 'https://www.youtube.com/watch?v=1VIZ89FEjYI',
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
                'film_trailer' => 'https://www.youtube.com/watch?v=vWgGkpp5ReU',
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
                'film_trailer' => 'https://www.youtube.com/watch?v=odM92ap8_c0',
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
                'film_trailer' => 'https://www.youtube.com/watch?v=hhiKQbGxEOw',
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
                'film_trailer' => 'https://www.youtube.com/watch?v=BxVyN_TndWg',
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
                'film_trailer' => 'https://www.youtube.com/watch?v=aJSh1zkPEvc',
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
                'film_trailer' => 'https://www.youtube.com/watch?v=LOZuxwVk7TU',
                'duration' => '2:00:00',
                'like' => '123',
                'film_description' => 'ABCDEFGH',
                'film_status' => 1
            ],
        ];

        DB::table('products')->insert($user);
    }

}
