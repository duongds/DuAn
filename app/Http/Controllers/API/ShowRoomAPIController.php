<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateShowRoomAPIRequest;
use App\Http\Requests\API\UpdateShowRoomAPIRequest;
use App\Models\ShowRoom;
use App\Repositories\ShowRoomRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ShowRoomResource;
use Response;

/**
 * Class ShowRoomController
 * @package App\Http\Controllers\API
 */

class ShowRoomAPIController extends AppBaseController
{
    /** @var  ShowRoomRepository */
    private $showRoomRepository;

    public function __construct(ShowRoomRepository $showRoomRepo)
    {
        $this->showRoomRepository = $showRoomRepo;
    }

    /**
     * Display a listing of the ShowRoom.
     * GET|HEAD /showRooms
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $showRooms = $this->showRoomRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($showRooms, 'Show Rooms retrieved successfully');
    }

    /**
     * Store a newly created ShowRoom in storage.
     * POST /showRooms
     *
     * @param CreateShowRoomAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateShowRoomAPIRequest $request)
    {
        $input = $request->all();

        $showRoom = $this->showRoomRepository->create($input);

        return $this->sendResponse($showRoom, 'Show Room saved successfully');
    }

    /**
     * Display the specified ShowRoom.
     * GET|HEAD /showRooms/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ShowRoom $showRoom */
        $showRoom = $this->showRoomRepository->find($id);

        if (empty($showRoom)) {
            return $this->sendError('Show Room not found');
        }

        return $this->sendResponse($showRoom, 'Show Room retrieved successfully');
    }

    /**
     * Update the specified ShowRoom in storage.
     * PUT/PATCH /showRooms/{id}
     *
     * @param int $id
     * @param UpdateShowRoomAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateShowRoomAPIRequest $request)
    {
        $input = $request->all();

        /** @var ShowRoom $showRoom */
        $showRoom = $this->showRoomRepository->find($id);

        if (empty($showRoom)) {
            return $this->sendError('Show Room not found');
        }

        $showRoom = $this->showRoomRepository->update($input, $id);

        return $this->sendResponse($showRoom, 'ShowRoom updated successfully');
    }

    /**
     * Remove the specified ShowRoom from storage.
     * DELETE /showRooms/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ShowRoom $showRoom */
        $showRoom = $this->showRoomRepository->find($id);

        if (empty($showRoom)) {
            return $this->sendError('Show Room not found');
        }

        $showRoom->delete();

        return $this->sendSuccess('Show Room deleted successfully');
    }
}
