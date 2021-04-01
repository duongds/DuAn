<?php
namespace App\Repositories;

class ProductRepository extends BaseRepository{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Product::class;
    }
}
