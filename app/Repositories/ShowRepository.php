<?php

namespace App\Repositories;

class ShowRepository extends BaseRepository
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
        return \App\Models\Show::class;
    }
    public function beforeAllQuery(){
        $this->query->with(['product' =>function ($query){
            $query->select('id','film_name');
        }]);
    }
}
