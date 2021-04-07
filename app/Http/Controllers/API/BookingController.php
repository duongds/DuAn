<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;

use App\Repositories\BookingRepository;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->bookingRepo->getAll();
        return $this->sendResponse($data, 'Get list booking successfully');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($data = $this->bookingRepo->create($request->all())) {
            return $this->sendResponse($data, 'Get list booking successfully');
        }
        return $this->sendError('cant get list booking');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->bookingRepo->find($id);
        return $this->sendResponse($data, 'Get show booking successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($data = $this->bookingRepo->update($request->all(), $id)) {
            return $this->sendResponse($data, 'Get list booking successfully');
        }
        return $this->sendError('update list booking fail');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->bookingRepo->delete($id)) {
            return $this->sendSuccess('delete list booking successfully');
        }
        return $this->sendError('delete list booking fail');
    }
}
