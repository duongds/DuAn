<?php
namespace App\Repositories;

class UserRepository extends BaseRepository{

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
        return \App\Models\User::class;
    }
    public function beforeAllQuery()
    {
        $this->query->with(['category' => function ($query) {
            $query->select('category.id', 'category.name');
        }]);
    }
}

