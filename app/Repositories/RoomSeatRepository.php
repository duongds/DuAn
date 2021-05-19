<?php

namespace App\Repositories;

use App\Models\RoomSeat;
use App\Repositories\BaseRepository;

/**
 * Class RoomSeatRepository
 * @package App\Repositories
 * @version May 19, 2021, 8:36 am UTC
*/

class RoomSeatRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'room_id',
        'seat_column',
        'seat_row',
        'condition',
        'type'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function getModel()
    {
        return RoomSeat::class;
    }
}
