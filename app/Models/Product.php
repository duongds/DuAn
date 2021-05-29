<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'film_name',
        'category',
        'poster',
        'duration',
        'like',
        'film_description',
        'film_status'
    ];

    public static $rules = [
    ];

    public function shows(){
        return $this->hasMany(Show::class);
    }

    public function category(){
        return $this->belongsToMany(Category::class, 'product_category_xref');
    }
}
