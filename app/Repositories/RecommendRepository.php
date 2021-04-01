<?php
namespace App\Repositories;

class RecommendRepository extends BaseRepository{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Recommend::class;
    }
}
