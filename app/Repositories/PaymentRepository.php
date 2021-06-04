<?php

namespace App\Repositories;

use App\Models\Payment;
use App\Repositories\BaseRepository;

/**
 * Class PaymentRepository
 * @package App\Repositories
 * @version May 19, 2021, 8:37 am UTC
*/

class PaymentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'amount',
        'show_id',
        'payment_date',
        'created_by',
        'deleted_by',
        'modified_by'
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
        return Payment::class;
    }

    public function moMoPayment(){
        $response = \MoMoAIO::purchase([
            'amount' => 20000,
            'returnUrl' => 'http://45.77.241.194:5000/',
            'notifyUrl' => 'http://45.77.241.194:5000/',
            'orderId' => 'Mã đơn hàng',
            'requestId' => 'Mã request id, gợi ý nên xài uuid4',
        ])->send();

        if ($response->isRedirect()) {
            $redirectUrl = $response->getRedirectUrl();

            // TODO: chuyển khách sang trang MoMo để thanh toán
        }
    }
}
