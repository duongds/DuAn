<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;



/**
 * Class Payment
 * @package App\Models
 * @version May 19, 2021, 8:37 am UTC
 *
 * @property \App\Models\User $user
 * @property \App\Models\Show $show
 * @property integer $user_id
 * @property string $amount
 * @property integer $show_id
 * @property string $payment_date
 * @property string $created_by
 * @property string $deleted_by
 * @property string $modified_by
 */
class Payment extends Model
{


    public $table = 'payments';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'user_id',
        'amount',
        'show_id',
        'payment_date',
        'created_by',
        'deleted_by',
        'modified_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'amount' => 'string',
        'show_id' => 'integer',
        'payment_date' => 'date',
        'created_by' => 'string',
        'deleted_by' => 'string',
        'modified_by' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required|integer',
        'amount' => 'nullable|string|max:255',
        'show_id' => 'required|integer',
        'payment_date' => 'nullable',
        'created_by' => 'nullable|string|max:255',
        'deleted_by' => 'nullable|string|max:255',
        'modified_by' => 'nullable|string|max:255'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function show()
    {
        return $this->belongsTo(\App\Models\Show::class, 'show_id');
    }
}
