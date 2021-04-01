<?php
namespace App\Repositories;

class PaymentRepository extends BaseRepository{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Payment::class;
    }
}
