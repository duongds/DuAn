<?php

namespace App\Repositories;

use App\Models\ShowRoom;

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
        'show_id',
        'room_id',
        'seat_column',
        'seat_row',
        'condition',
        'type',
        'show_time'
    ];

    protected $fieldInList = [
        'id',
        'show_id',
        'room_id',
        'seat_column',
        'seat_row',
        'condition',
        'type',
        'show_time'
    ];

    protected $fieldFilter = [
        'id'
    ];

    protected $fieldOrder = [
        'id'
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

    public function filterShowId($value)
    {
        $this->query->where('show_id', $value);
    }

    public function filterRoomId($value)
    {
        $this->query->where('room_id', $value);
    }

    public function filterShowTime($value)
    {
        $this->query->where('show_time', $value);
    }
}
