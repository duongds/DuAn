<?php

namespace App\Repositories;

use App\Models\ShowRoom;
use App\Repositories\BaseRepository;

/**
 * Class ShowRoomRepository
 * @package App\Repositories
 * @version May 18, 2021, 6:50 am UTC
*/

class ShowRoomRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'room_show_id',
        'seat_column',
        'seat_row',
        'condition',
        'type',
        'show_time'
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
        return ShowRoom::class;
    }
}
