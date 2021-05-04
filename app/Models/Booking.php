<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Booking
 * @package App\Models
 *
 * @property integer $id
 * @property integer $show_id
 * @property string $booking_seat
 * @property string $booking_time
 * @property string $created_by
 * @property string $updated_by
 * @property string $deleted_by
 */
class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bookings';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'id',
        'show_id',
        'booking_seat',
        'booking_time',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

}
