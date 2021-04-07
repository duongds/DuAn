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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=$this->paymentRepo->getAll();
        return response()->json($data,Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function create()
//    {
//        //
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($data = $this-> paymentRepo->create($request->all())){
            return response()->json($data, Response::HTTP_OK);
        }
        return response('false', Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.*
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=$this->paymentRepo->find($id);
        return response()->json($data,Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function edit($id)
//    {
//        //
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($data = $this->paymentRepo->update($request->all(),$id)) {
            return response('success', Response::HTTP_OK);
        }
        return response('false', Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->paymentRepo->delete($id)) {
            return response('success', Response::HTTP_OK);
        }
        return response('false', Response::HTTP_BAD_REQUEST);
    }
}
