<?php

namespace App\Repositories;

class ShowRepository extends BaseRepository
{

    protected $fieldSearchable = [
        'product_id',
        'show_time',
        'show_date'
    ];

    protected $fieldInList = [
        'product_id',
        'show_time',
        'show_date',
        'room_id',
        'room_status',
        'film_status'
    ];

    protected $fieldOrder = [
        'id'
    ];

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

    public function beforeAllQuery()
    {
        $this->query->with(['product' => function ($query) {
            $query->select('id', 'film_name');
        }]);
    }

    public function filterProductId($value)
    {
        if ($value) {
            $this->query->where('product_id', $value);
        }
    }

    public function filterShowTime($value)
    {
        if ($value) {
            $this->query->where('show_time', $value);
        }
    }

    public function filterShowDate($value)
    {
        if ($value) {
            $this->query->where('show_date', $value);
        }
    }


}
