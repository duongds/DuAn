<?php

namespace App\Repositories;

class RoomRepository extends BaseRepository
{

    protected $fieldSearchable = [
        'room_id'
    ];

    protected $fieldOrder = ['id'];

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
        return \App\Models\Room::class;
    }

    public function filterRoomId($value){
        if ($value){
            $this->query->where('id', $value);
        }
    }

    public function beforeAllQuery(){
        $this->query->with(['room_seat' => function($qe){
            $qe->select('seat_column', 'seat_row', 'condition', 'type', 'room_id');
        }]);
    }
}
