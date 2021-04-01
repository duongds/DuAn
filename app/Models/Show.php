<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Show extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=[
        'product_id',
        'Create_at',
        'room_id'
    ];
}
