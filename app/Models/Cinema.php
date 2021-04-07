<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static whereHas(string $string, \Closure $param)
 */
class Cinema extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='cinemas';
    protected $fillable=[
        'name',
        'location',
        'image'
    ];
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
