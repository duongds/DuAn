<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Show extends Model
{
    use HasFactory, SoftDeletes, Compoships;

    protected $table = 'shows';

    protected $fillable = [
        'product_id',
        'show_time',
        'show_date',
        'room_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function show_room(){
        return $this->hasMany(ShowRoom::class, ['show_id', 'room_id'], ['id', 'room_id']);
    }
}
