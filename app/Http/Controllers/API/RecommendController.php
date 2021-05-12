<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;

use App\Repositories\RecommendRepository;
use App\Utils\CommonUtils;
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
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $search = $request->except(['skip', 'limit']);
        $limit = $request->get('limit', CommonUtils::DEFAULT_LIMIT);
        $data = $this->recommendRepo->paginate($search, $limit, null, null);
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
        if ($data = $this-> recommendRepo->create($input)){
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
        $input = $request->all();
        if ($data = $this->recommendRepo->update($input,$id)) {
            return $this->sendResponse($data,'Update recommend successfully');
        }
        return $this->sendError('cant update recommend');
    }

    public function destroy($id)
    {
        if ($this->recommendRepo->delete($id)) {
            return $this->sendSuccess('delete successfully');
        }
        return $this->sendError('cant delete');
    }
}
