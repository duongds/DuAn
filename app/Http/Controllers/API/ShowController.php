<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;

use App\Repositories\ShowRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShowController extends AppBaseController
{
    protected $showRepo;
    public function __construct(ShowRepository  $showRepository){
        $this->showRepo=$showRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data=$this->showRepo->getAll();
        return $this->sendResponse($data,'Get show successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if ($data = $this-> showRepo->create($request->all())){
            return $this->sendResponse($data,'Store show successfully');
        }
        return $this->sendError('Cant store show');
    }

    /**
     * Display the specified resource.*
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $data=$this->showRepo->find($id);
        return $this->sendResponse($data,'show successfully');
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
        if ($data = $this->showRepo->update($request->all(),$id)) {
            return $this->sendResponse($data,'update successfully');
        }
        return $this->sendError('cant update show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->showRepo->delete($id)) {
            return $this->sendSuccess('delete successfully');
        }
        return $this->sendError('cant delete');
    }
}
