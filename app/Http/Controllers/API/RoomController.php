<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Repositories\RoomRepository;
use App\Utils\CommonUtils;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoomController extends AppBaseController
{
    protected $roomRepo;

    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepo = $roomRepository;
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
        $data = $this->roomRepo->paginate($search, $limit, null, null);
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
        if ($data = $this->roomRepo->create($input)) {
            return $this->sendResponse($data, 'Store successfully');
        }
        return $this->sendError('cant store');
    }

    /**
     * Display the specified resource.*
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->roomRepo->find($id);
        return $this->sendResponse($data, 'Show roo, successfully');
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
        if ($data = $this->roomRepo->update($input, $id)) {
            return $this->sendResponse($data, 'Update room successfully');
        }
        return $this->sendError('cant update room');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        if ($this->roomRepo->delete($id)) {
            return $this->sendSuccess('delete successfully');
        }
        return $this->sendError('cant delete');
    }

    public function getSelectList(Request $request)
    {
        $input = $request->except(['skip', 'limit']);
        $data = $this->roomRepo->allQuery($input, null, null, null)->get();
        return $this->sendResponse($data, 'get room successfully');
    }
}
