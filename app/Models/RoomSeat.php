<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;



/**
 * Class RoomSeat
 * @package App\Models
 * @version May 19, 2021, 8:36 am UTC
 *
 * @property \App\Models\Room $room
 * @property integer $room_id
 * @property string $seat_column
 * @property string $seat_row
 * @property string $condition
 * @property string $type
 */
class RoomSeat extends Model
{


    public $table = 'room_seat';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'room_id',
        'seat_column',
        'seat_row',
        'condition',
        'type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'room_id' => 'integer',
        'seat_column' => 'string',
        'seat_row' => 'string',
        'condition' => 'string',
        'type' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'room_id' => 'required|integer',
        'seat_column' => 'required|string|max:255',
        'seat_row' => 'required|string|max:255',
        'condition' => 'required|string|max:255',
        'type' => 'required|string|max:255'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function room()
    {
        return $this->hasOne(\App\Models\Room::class);
    }
}
