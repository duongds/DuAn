<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserCategoryXref extends Model
{
    protected $table = 'user_category_xref';

    protected $fillable = [
        'users_id',
        'category_id',
        'count'
    ];
}
