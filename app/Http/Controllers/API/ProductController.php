<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Repositories\ProductRepository;
use App\Utils\CommonUtils;
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
    public function index(Request $request)
    {
        $search = $request->except(['skip', 'limit']);
        $limit = $request->get('limit', CommonUtils::DEFAULT_LIMIT);
        $data = $this->productRepo->paginate($search, $limit, null, null);
        return $this->sendResponse($data, 'Get list booking successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        if ($data = $this-> productRepo->create($input)){
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
        return $this->sendResponse($data,'Show product successfully');
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
        $input = $request->all();
        if ($data = $this->productRepo->update($input,$id)) {
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
    public function filterName(Request $request){
        $name = $request->get('name');
        $data = $this->productRepo->findByName($name);
        return $this->sendResponse($data, 'get product successfully');
    }
}
