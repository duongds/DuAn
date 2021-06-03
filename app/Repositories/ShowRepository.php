<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Show;
use function Clue\StreamFilter\fun;

class ShowRepository extends BaseRepository
{

    protected $fieldSearchable = [
        'product_id',
        'show_time',
        'show_date',
        'room_id'
    ];

    protected $fieldInList = [
        'id',
        'product_id',
        'show_time',
        'show_date',
        'room_id'
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
        $this->query->with(['product' => function ($qr) {
            $qr->select('products.id', 'products.film_name', 'products.poster', 'products.duration', 'products.like', 'products.film_description', 'products.film_status')->with(['category' => function ($qx) {
                $qx->select('category.id', 'category.name', 'product_category_xref.product_id', 'product_category_xref.category_id');
            }]);
        }, 'show_room' => function ($qx) {
            $qx->select('*');
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

    public function filterRoomId($value)
    {
        if ($value) {
            $this->query->where('room_id', $value);
        }
    }

    public function validateShow($product_id, $room_id, $show_date, $show_time)
    {
        $shows = Show::where('room_id', $room_id)->where('show_date', $show_date)->with(['product' => function ($query) {
            $query->select('*');
        }])->get()->toArray();

        $product = Product::where('id', $product_id)->first();
        $hour = substr($product->duration, 0, 2) * 60 * 60;
        $minute = substr($product->duration, 3, 2) * 60;
        $second = (int)substr($product->duration, 6, 2);
//        dd($hour, $minute, $second);
//        if (strtotime($show[0]) )
        foreach ($shows as $show) {
            $hour_exits = substr($show['product']['duration'], 0, 2) * 60 * 60;
            $minute_exits = substr($show['product']['duration'], 3, 2) * 60;
            $second_exits = (int)substr($show['product']['duration'], 6, 2);
            // tg thêm mới > tg đã đặt + duration + 30 p hoặc tg thêm mới + duration + 30 phút < tg đã đặt
            if (strtotime($show_time) + $hour + $minute + $second + 30 * 60 > strtotime($show['show_time']) && strtotime($show_time) < strtotime($show['show_time']) ||
                strtotime($show['show_time']) + $hour_exits + $minute_exits + $second_exits + 30 * 60 > strtotime($show_time) && strtotime($show_time) > strtotime($show['show_time'])) {
                return false;
            }
        }
        return true;
    }
}
