<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;

use App\Repositories\PaymentRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentController extends AppBaseController
{
    protected $paymentRepo;
    public function __construct(PaymentRepository  $paymentRepository){
        $this->paymentRepo=$paymentRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data=$this->paymentRepo->getAll();
        return $this->sendResponse($data,"Get list payment successfully");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if ($data = $this-> paymentRepo->create($request->all())){
            return $this->sendResponse($data,'Store payment successfully');
        }
        return $this->sendError('Cant store payment');
    }

    /**
     * Display the specified resource.*
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $data=$this->paymentRepo->find($id);
        return $this->sendResponse($data,'show payment');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        if ($data = $this->paymentRepo->update($request->all(),$id)) {
            return $this->sendResponse($data,'Update payment successfully');
        }
        return $this->sendError('Cant update payment');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->paymentRepo->delete($id)) {
            return $this->sendSuccess('Delete payment successfully');
        }
        return $this->sendError('cant delete payment');
    }
}
