<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreatePaymentAPIRequest;
use App\Http\Requests\API\UpdatePaymentAPIRequest;
use App\Models\Payment;
use App\Models\UserCategoryXref;
use App\Repositories\PaymentRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ShowRoomRepository;
use App\Repositories\UserCategoryXrefRepository;
use App\Repositories\UserRepository;
use App\Utils\CommonUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Omnipay\Omnipay;
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
    private $productRepository;
    private $userCategoryXrefRepository;

    public function __construct(PaymentRepository $paymentRepo,
                                ShowRoomRepository $showRoomRepo,
                                UserRepository $userRepo,
                                ProductRepository $productRepo,
                                UserCategoryXrefRepository $userCategoryXrefRepo)
    {
        $this->paymentRepository = $paymentRepo;
        $this->showRoomRepository = $showRoomRepo;
        $this->userRepository = $userRepo;
        $this->productRepository = $productRepo;
        $this->userCategoryXrefRepository = $userCategoryXrefRepo;
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
        $user = \Auth::user();
        $seat_arr = $input['show_room'] ?? '';

        $payment_info = [
            'user_id' => $user->id,
            'amount' => $input['paid_amount'],
            'payment_date' => Carbon::now()
        ];
        $payment = $this->paymentRepository->create($payment_info);

        foreach ($seat_arr as $seat) {
            $seat['payment_id'] = $payment->id;
            $seat['condition'] = 1;
            $this->showRoomRepository->update($seat, $seat['id']);
        }
        $product = $this->productRepository->find($input['product_id'])->toArray();
        $category_product = $product['category'];
        foreach($category_product as $category){
            $recommend = UserCategoryXref::where('user_id', $user->id)->where('category_id', $category['id'])->first()->toArray();
            $recommend['count']++;
            $this->userCategoryXrefRepository->update($recommend, $recommend['id']);
        }
        $update_user = $user->toArray();
        $update_user['member_point'] += $input['mem_pts_plus'] * 5;
        $this->userRepository->update($update_user, $user->id);


        // thông tin cuối khách hàng nhận được
        $user_payment = [
            'payment_id' => $payment->id,
            'user' => $user->name,
            'show_room' => $seat_arr
        ];

        return $this->sendResponse($user_payment, 'Payment saved successfully');
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

    public function calculateUserPayment(Request $request)
    {
        //thông tin user
        $input = $request->all();
        $user = $this->userRepository->getModel()::where('id', $input['user_id'])->first();
        $last_monday = date("Y-m-d H:i:s", strtotime("last Monday of now"));
        $mem_pts_plus = 0;
//        dd($date , (string)Carbon::now());
        //giá tiền phải trả
        $paid_amount = 0;
        // số lượng ghế đặt.
        $seat_arr = $input['show_room'] ?? '';
        foreach ($seat_arr as $seat) {
            $price = 0;
            switch ($seat['type']) {
                case 'normal' :
                    $mem_pts_plus++;
                    $price = CommonUtils::normalSeatPrice;
                    break;
                case 'vip' :
                    $mem_pts_plus += 2;
                    $price = CommonUtils::vipSeatPrice;
                    break;
                case 'sweetbox' :
                    $mem_pts_plus += 3;
                    $price = CommonUtils::sweetBoxSeatPrice;
                    break;
            }

            //calculate
            if (substr($last_monday, 0, 10) == substr((string)Carbon::now(), 0, 10)) {
                $paid_amount += CommonUtils::lastMondayPrice;
                continue;
            } else if ($user['is_u22']) {
                $paid_amount += CommonUtils::u22Price;
                continue;
            } else {
                // member bạc
                if (50 <= $user['member_point'] && $user['member_point'] < 200) {
                    $paid_amount += ($price - $price * 5 / 100);
                } //member vàng
                else if (200 <= $user['member_point'] && $user['member_point'] < 500) {
                    $paid_amount += ($price - $price * 10 / 100);
                } //member kim cương
                else if (500 <= $user['member_point']) {
                    $paid_amount += ($price - $price * 20 / 100);
                } else {
                    $paid_amount += $price;
                }
                continue;
            }
        }
        $payment = $input;
        $payment['paid_amount'] = $paid_amount;
        $payment['mem_pts_plus'] = $mem_pts_plus;
        return $this->sendResponse($payment, 'Payment saved successfully');
    }

    public function redirectMoMoPayment(Request $request)
    {
        $input = $request->all();
        $gateway = Omnipay::create('MoMo_AllInOne');
        $gateway->initialize([
            'accessKey' => 'RRsnLaTBWn5eSv1j',
            'partnerCode' => 'MOMOAWPY20210524',
            'secretKey' => 'Jhcnxmfz45IyVdX5ixXm4kOO4vy37gG6',
        ]);
        $response = $gateway->purchase([
            'amount' => $input['amount'],
            'returnUrl' => $input['returnUrl'],
            'notifyUrl' => $input['notifyUrl'],
            'orderId' => $input['orderId'],
            'requestId' => $input['requestId'],
        ])->send();

        $user_request = $response->getData();
        if ($user_request['errorCode'] == 0) {
            return $user_request['payUrl'];
            // TODO: chuyển khách sang trang MoMo để thanh toán
        }

        return $this->sendError($user_request['message'], 404);
    }

    public function confirmMoMoPayment()
    {
        \DB::table('payments')->where('amount', 27000)->delete();
    }
}
