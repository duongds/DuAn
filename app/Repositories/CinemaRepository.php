<?php
namespace App\Repositories;

class CinemaRepository extends BaseRepository{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Cinema::class;
    }
}
