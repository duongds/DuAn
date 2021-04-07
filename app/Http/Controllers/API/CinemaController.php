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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->cinemaRepo->getAll();
        return response()->json($data, Response::HTTP_OK);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($data = $this->cinemaRepo->create($request->all())) {
            return response()->json($data, Response::HTTP_OK);
        }
        return response('false', Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.*
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->cinemaRepo->find($id);
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
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
        if ($data = $this->cinemaRepo->update($request->all(), $id)) {
            return response('success', Response::HTTP_OK);
        }
        return response('false', Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->cinemaRepo->delete($id)) {
            return response('success', Response::HTTP_OK);
        }
        return response('false', Response::HTTP_BAD_REQUEST);
    }

    public function searchFromRoom(Request $request)
    {
        $room = $request->name;
        $cinema = Cinema::whereHas('rooms', function (Builder $querry) use ($room) {
            $querry->where('name', $room);
        })->get();
        return $cinema;
    }
}
