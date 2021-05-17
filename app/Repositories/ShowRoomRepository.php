<?php


namespace App\Repositories;


class ShowRoomRepository extends BaseRepository
{

    protected $fieldSearchable = [
    ];

    protected $fieldInList = [
        'room_show_id',
        'seat_column',
        'seat_row',
        'condition',
        'type',
        'show_time'
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
        return \App\Models\ShowRoom::class;
    }
}
