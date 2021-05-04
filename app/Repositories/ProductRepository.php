<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends BaseRepository
{

    protected $fieldSearchable = [];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Product::class;
    }

    public function findByName($name)
    {
        if ($name) {
            return Product::where('film_name', 'like', '%' . $name . '%')->get();
        }
    }
}
