<?php

namespace App\Repositories;

class ProductRepository extends BaseRepository
{

    protected $fieldSearchable = [
        'film_name',
        'film_status'
    ];

    protected $fieldInList = [
        'id',
        'film_name',
        'poster',
        'duration',
        'like',
        'film_description',
        'film_status',
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
        return \App\Models\Product::class;
    }

    public function filterFilmName($value)
    {
        if ($value) {
            $name = $this->processSearch($value);
            $this->query->where('film_name', 'like', '%' . $name . '%');
        }
    }

    public function filterFilmStatus($value)
    {
        if (!is_null($value)) {
            $this->query->where('film_status', $value);
        }
    }

    public function beforeAllQuery()
    {
        $this->query->with(['category' => function ($query) {
            $query->select('category.id', 'category.name');
        }]);
    }
}
