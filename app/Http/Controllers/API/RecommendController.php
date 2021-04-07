<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;

use App\Repositories\RecommendRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RecommendController extends AppBaseController
{
    protected $recommendRepo;
    public function __construct(RecommendRepository  $recommendRepository){
        $this->recommendRepo=$recommendRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data=$this->recommendRepo->getAll();
        return $this->sendResponse($data,'Get Recommend successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if ($data = $this-> recommendRepo->create($request->all())){
            return $this->sendResponse($data,'Store recommend successfully');
        }
        return $this->sendError('cant store recommend');
    }

    /**
     * Display the specified resource.*
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $data=$this->recommendRepo->find($id);
        return $this->sendResponse($data,'Show recommend');
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
        if ($data = $this->recommendRepo->update($request->all(),$id)) {
            return $this->sendResponse($data,'Update recommend successfully');
        }
        return $this->sendError('cant update recommend');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->recommendRepo->delete($id)) {
            return $this->sendSuccess('delete successfully');
        }
        return $this->sendError('cant delete');
    }
}
