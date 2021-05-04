<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Repositories\BookingRepository;
use App\Utils\CommonUtils;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookingController extends AppBaseController
{
    protected $bookingRepo;

    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepo = $bookingRepository;
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
        $data = $this->bookingRepo->paginate($search, $limit, null, null);
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
        if ($data = $this->bookingRepo->create($input)) {
            return $this->sendResponse($data, 'store booking successfully');
        }
        return $this->sendError('cant get list booking');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->bookingRepo->find($id);
        return $this->sendResponse($data, 'Get show booking successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        if ($data = $this->bookingRepo->update($input, $id)) {
            return $this->sendResponse($data, 'Get list booking successfully');
        }
        return $this->sendError('update list booking fail');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->bookingRepo->delete($id)) {
            return $this->sendSuccess('delete list booking successfully');
        }
        return $this->sendError('delete list booking fail');
    }
}
