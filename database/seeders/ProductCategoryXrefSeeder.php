<?php


namespace Database\Seeders;


use App\Utils\CommonUtils;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategoryXrefSeeder extends Seeder
{
    public function run()
    {
        $mapping = [
            [
                'product_id' => 1,
                'category_id' => 0
            ],
            [
                'product_id' => 1,
                'category_id' => 1
            ],
            [
                'product_id' => 2,
                'category_id' => 1
            ],
            [
                'product_id' => 2,
                'category_id' => 0
            ],
            [
                'product_id' => 2,
                'category_id' => 3
            ],
            [
                'product_id' => 4,
                'category_id' => 1
            ],
            [
                'product_id' => 5,
                'category_id' => 1
            ],
            [
                'product_id' => 6,
                'category_id' => 1
            ],
            [
                'product_id' => 7,
                'category_id' => 1
            ],
            [
                'product_id' => 7,
                'category_id' => 0
            ],
            [
                'product_id' => 5,
                'category_id' => 0
            ],
            [
                'product_id' => 4,
                'category_id' => 3
            ],
            [
                'product_id' => 5,
                'category_id' => 5
            ],
            [
                'product_id' => 7,
                'category_id' => 6
            ],
            [
                'product_id' => 1,
                'category_id' => 6
            ],
        ];
        DB::table('product_category_xref')->insert($mapping);
    }

}
