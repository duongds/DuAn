<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ProductCategoryXref extends Model
{
    protected $table = 'product_category_xref';

    protected $fillable = [
        'product_id',
        'category_id'
    ];
}
