<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;

use App\Models\Cinema;
use App\Repositories\CinemaRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CinemaController extends AppBaseController
{
    protected $cinemaRepo;

    public function __construct(CinemaRepository $cinemaRepository)
    {
        $this->cinemaRepo = $cinemaRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = $this->cinemaRepo->getAll();
        return $this->sendResponse($data,'Get list cinema successfully');
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
        if ($data = $this->cinemaRepo->create($input)) {
            return $this->sendResponse($data,'Store cinema successfully');
        }
        return $this->sendError('cant store cinema');
    }

    /**
     * Display the specified resource.*
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->cinemaRepo->find($id);
        return $this->sendResponse($data,'show cinema successfully');
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
        if ($data = $this->cinemaRepo->update($input, $id)) {
            return $this->sendResponse($data,'Update cinema successfully');
        }
        return $this->sendError('cant update cinema');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->cinemaRepo->delete($id)) {
            return $this->sendSuccess('delete cinema');
        }
        return $this->sendError('cant delete cinema');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function searchFromRoom(Request $request)
    {
        $room = $request->name;
        $cinema = Cinema::whereHas('rooms', function (Builder $query) use ($room) {
            $query->where('name', $room);
        })->get();
        return $this->sendResponse($cinema,'search');
    }
}
