<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'rooms';

    protected $fillable = [
        'cinema_id',
        'name',
        'type'
    ];

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }
}
