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
        'poster',
        'film_trailer',
        'duration',
        'director',
        'actor',
        'like',
        'film_description',
        'film_status',
        'language'
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
