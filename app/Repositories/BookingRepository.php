<?php
namespace App\Repositories;

class BookingRepository extends BaseRepository{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Booking::class;
    }
}
