<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateRoomSeatAPIRequest;
use App\Http\Requests\API\UpdateRoomSeatAPIRequest;
use App\Models\RoomSeat;
use App\Repositories\RoomSeatRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\RoomSeatResource;
use Response;

/**
 * Class RoomSeatController
 * @package App\Http\Controllers\API
 */

class RoomSeatAPIController extends AppBaseController
{
    /** @var  RoomSeatRepository */
    private $roomSeatRepository;

    public function __construct(RoomSeatRepository $roomSeatRepo)
    {
        $this->roomSeatRepository = $roomSeatRepo;
    }

    /**
     * Display a listing of the RoomSeat.
     * GET|HEAD /roomSeats
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $roomSeats = $this->roomSeatRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($roomSeats, 'Room Seats retrieved successfully');
    }

    /**
     * Store a newly created RoomSeat in storage.
     * POST /roomSeats
     *
     * @param CreateRoomSeatAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateRoomSeatAPIRequest $request)
    {
        $input = $request->all();

        $roomSeat = $this->roomSeatRepository->create($input);

        return $this->sendResponse($roomSeat, 'Room Seat saved successfully');
    }

    /**
     * Display the specified RoomSeat.
     * GET|HEAD /roomSeats/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var RoomSeat $roomSeat */
        $roomSeat = $this->roomSeatRepository->find($id);

        if (empty($roomSeat)) {
            return $this->sendError('Room Seat not found');
        }

        return $this->sendResponse($roomSeat, 'Room Seat retrieved successfully');
    }

    /**
     * Update the specified RoomSeat in storage.
     * PUT/PATCH /roomSeats/{id}
     *
     * @param int $id
     * @param UpdateRoomSeatAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRoomSeatAPIRequest $request)
    {
        $input = $request->all();

        /** @var RoomSeat $roomSeat */
        $roomSeat = $this->roomSeatRepository->find($id);

        if (empty($roomSeat)) {
            return $this->sendError('Room Seat not found');
        }

        $roomSeat = $this->roomSeatRepository->update($input, $id);

        return $this->sendResponse($roomSeat, 'RoomSeat updated successfully');
    }

    /**
     * Remove the specified RoomSeat from storage.
     * DELETE /roomSeats/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var RoomSeat $roomSeat */
        $roomSeat = $this->roomSeatRepository->find($id);

        if (empty($roomSeat)) {
            return $this->sendError('Room Seat not found');
        }

        $roomSeat->delete();

        return $this->sendSuccess('Room Seat deleted successfully');
    }
}
