<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;



/**
 * Class ShowRoom
 * @package App\Models
 * @version May 18, 2021, 6:50 am UTC
 *
 * @property integer $room_show_id
 * @property string $seat_column
 * @property string $seat_row
 * @property string $condition
 * @property string $type
 * @property string|\Carbon\Carbon $show_time
 */
class ShowRoom extends Model
{


    public $table = 'show_room';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'show_id',
        'room_id',
        'seat_column',
        'seat_row',
        'condition',
        'type',
        'show_time'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'show_id' => 'integer',
        'room_id' => 'integer',
        'payment_id' => 'integer',
        'seat_column' => 'string',
        'seat_row' => 'string',
        'condition' => 'string',
        'type' => 'string',
        'show_time' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    ];

    
}
