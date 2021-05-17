<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomSeat extends Model
{
    use HasFactory;
    protected $table ='room_seat';
    protected $fillable = [
        'room_id',
        'seat_column',
        'seat-row',
        'condition',
        'type'
    ];
}
