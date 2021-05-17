<?php


namespace App\Repositories;


class RoomSeatRepository extends BaseRepository
{

    protected $fieldSearchable = [
    ];

    protected $fieldInList = [
        'room_id',
        'seat_column',
        'seat_row',
        'condition',
        'type',
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
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\RoomSeat::class;
    }
}
