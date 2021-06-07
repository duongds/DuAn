<?php


namespace App\Repositories;


use App\Models\UserCategoryXref;

class UserCategoryXrefRepository extends BaseRepository
{

    protected $fieldSearchable = [];

    protected $fieldInList = [
        'user_id',
        'category_id',
        'count'
    ];
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
        return UserCategoryXref::class;
    }
}
