<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreatePaymentAPIRequest;
use App\Http\Requests\API\UpdatePaymentAPIRequest;
use App\Models\Payment;
use App\Repositories\PaymentRepository;
use App\Repositories\ShowRoomRepository;
use App\Repositories\UserRepository;
use App\Utils\CommonUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Response;

/**
 * Class PaymentController
 * @package App\Http\Controllers\API
 */
class PaymentAPIController extends AppBaseController
{
    /** @var  PaymentRepository */
    private $paymentRepository;
    private $showRoomRepository;
    private $userRepository;

    public function __construct(PaymentRepository $paymentRepo, ShowRoomRepository $showRoomRepo, UserRepository $userRepo)
    {
        $this->paymentRepository = $paymentRepo;
        $this->showRoomRepository = $showRoomRepo;
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the Payment.
     * GET|HEAD /payments
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $payments = $this->paymentRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($payments, 'Payments retrieved successfully');
    }

    /**
     * Store a newly created Payment in storage.
     * POST /payments
     *
     * @param CreatePaymentAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePaymentAPIRequest $request)
    {
        $input = $request->all();
        //thông tin user
        $user = $this->userRepository->getModel()::where('id', $input['user_id'])->first();
        $last_monday = date("Y-m-d H:i:s", strtotime("last Monday of now"));
//        dd($date , (string)Carbon::now());
        //giá tiền phải trả
        $paid_amount = 0;
        // số lượng ghế đặt.
        $seat_arr = $input['show_room'] ?? '';
        foreach ($seat_arr as $seat) {
            $price = 0;
            switch ($seat['type']) {
                case 'normal' :
                    $price = CommonUtils::normalSeatPrice;
                    break;
                case 'vip' :
                    $price = CommonUtils::vipSeatPrice;
                    break;
                case 'sweetbox' :
                    $price = CommonUtils::sweetBoxSeatPrice;
                    break;
            }
            if (substr($last_monday, 0, 10) == substr((string)Carbon::now(), 0, 10)) {
                $paid_amount += 5000;
                continue;
            } else if ($user['is_u22']) {
                $paid_amount += 7000;
                continue;
            } else {
                switch ($user['member_point']) {
                    case $user['member_point'] >= 50  :
                        $paid_amount = $paid_amount + $price - $price * 5 / 100;
                        break;
                    case $user['member_point'] >= 200  :
                        $paid_amount = $paid_amount + $price - $price * 10 / 100;
                        break;
                    case $user['member_point'] >= 500  :
                        $paid_amount = $paid_amount + $price - $price * 20 / 100;
                        break;
                    default :
                        $paid_amount = $price;
                        break;
                }
                continue;
            }
        }
        dd($paid_amount);

//        \DB::beginTransaction();
//        try {
//
//        } catch (\Exception $e) {
//            \DB::rollBack();
//
//            return $this->sendError($e);
//        }

        $payment = $this->paymentRepository->create($input);

        return $this->sendResponse($payment, 'Payment saved successfully');
    }

    /**
     * Display the specified Payment.
     * GET|HEAD /payments/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Payment $payment */
        $payment = $this->paymentRepository->find($id);

        if (empty($payment)) {
            return $this->sendError('Payment not found');
        }

        return $this->sendResponse($payment, 'Payment retrieved successfully');
    }

    /**
     * Update the specified Payment in storage.
     * PUT/PATCH /payments/{id}
     *
     * @param int $id
     * @param UpdatePaymentAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePaymentAPIRequest $request)
    {
        $input = $request->all();

        /** @var Payment $payment */
        $payment = $this->paymentRepository->find($id);

        if (empty($payment)) {
            return $this->sendError('Payment not found');
        }

        $payment = $this->paymentRepository->update($input, $id);

        return $this->sendResponse($payment, 'Payment updated successfully');
    }

    /**
     * Remove the specified Payment from storage.
     * DELETE /payments/{id}
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var Payment $payment */
        $payment = $this->paymentRepository->find($id);

        if (empty($payment)) {
            return $this->sendError('Payment not found');
        }

        $payment->delete();

        return $this->sendSuccess('Payment deleted successfully');
    }
}
