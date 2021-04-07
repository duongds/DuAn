<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends AppBaseController
{
    protected $productRepo;
    public function __construct(ProductRepository  $productRepository){
        $this->productRepo=$productRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data=$this->productRepo->getAll();
        return $this->sendResponse($data,'Get list Product successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if ($data = $this-> productRepo->create($request->all())){
            return $this->sendResponse($data,'Store product successfully');
        }
        return $this->sendError('cant update product');
    }

    /**
     * Display the specified resource.*
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $data=$this->productRepo->find($id);
        return $this->sendResponse('Show product successfully');
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
        if ($data = $this->productRepo->update($request->all(),$id)) {
            return $this->sendResponse($data,'Update product successfully');
        }
        return $this->sendError('cant update product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->productRepo->delete($id)) {
            return $this->sendSuccess('Delete successfully');
        }
        return $this->sendError('cant delete');
    }
}
