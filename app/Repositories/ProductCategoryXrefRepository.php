<?php


namespace App\Repositories;


use App\Models\ProductCategoryXref;

class ProductCategoryXrefRepository extends BaseRepository
{

    protected $fieldSearchable = [];
    /**
     * @inheritDoc
     */
    public function getFieldsSearchable()
    {
        // TODO: Implement getFieldsSearchable() method.
        return $this->fieldSearchable;
    }

    /**
     * @inheritDoc
     */
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return ProductCategoryXref::class;
    }

    public function updatePivot(){

    }
}
