<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\UserCategoryXref;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function recommendProduct()
    {
        $id = Auth::id();
        $listId = DB::table('user_category_xref')
            ->select('category_id')
            ->where('user_id', $id)
            ->orderByDesc('count')
            ->limit(3)->get();
        $listId=$listId->pluck('category_id');
        $products= Product::whereHas('category',function ($query) use($listId){
            $query->whereIn('category.id', $listId);
        })->get();
        return $products;
    }

    public function beforeAllQuery()
    {
        $this->query->with(['category' => function ($query) {
            $query->select('category.id', 'category.name');
        }]);
    }
}
