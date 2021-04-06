<?php
namespace App\Repositories;

class ShowRepository extends BaseRepository{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Show::class;
    }
}
