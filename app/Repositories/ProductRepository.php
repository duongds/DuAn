<?php
namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends BaseRepository{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Product::class;
    }
    public function findByName($name){
        if ($name){
            return Product::where('film_name','like','%'.$name.'%')->get();
        }
        else{
            return null;
        }
    }
}
