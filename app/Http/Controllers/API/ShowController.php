<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\ShowRoom;
use App\Repositories\RoomRepository;
use App\Repositories\ShowRepository;
use App\Repositories\ShowRoomRepository;
use App\Utils\CommonUtils;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShowController extends AppBaseController
{
    protected $showRepository;
    protected $roomRepository;
    protected $showRoomRepository;

    public function __construct(ShowRepository $showRepo, RoomRepository $roomRepo, ShowRoomRepository $showRoomRepo)
    {
        $this->showRepository = $showRepo;
        $this->roomRepository = $roomRepo;
        $this->showRoomRepository = $showRoomRepo;
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
        $data = $this->showRepository->paginate($search, $limit, null, ['id' => 'desc']);
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

        if (!$this->showRepository->validateShow($input['product_id'], $input['room_id'], $input['show_date'], $input['show_time'])) {
            return $this->sendError('Show thêm mới trùng với show khác');
        }

        if(!isset($input['show_date']) && !isset($input['show_time'])){
            return $this->sendError('Show thêm mới cần có thời gian cụ thể');
        }
        \DB::beginTransaction();
        try {

            $data = $this->showRepository->create($input);
            $room_data = $this->roomRepository->all(['room_id' => $input['room_id']], null, null, null, null)->toArray();
            foreach ($room_data[0]['room_seat'] as $room) {
                $room['show_id'] = $data->id;
                $room['show_time'] = $date_time = date('Y-m-d H:i:s', strtotime($input['show_date'] . $input['show_time']));
                ShowRoom::insert([$room]);
            }
            \DB::commit();
            return $this->sendResponse($data, 'Store show successfully');

        } catch (\Exception $e) {
            \DB::rollBack();

            return $this->sendError($e);
        }
    }

    /**
     * Display the specified resource.*
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->showRepository->find($id);
        return $this->sendResponse($data, 'show successfully');
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
        if ($data = $this->showRepository->update($input, $id)) {
            return $this->sendResponse($data, 'update successfully');
        }
        return $this->sendError('cant update show');
    }

    public function destroy($id)
    {
        if ($this->showRepository->delete($id)) {
            return $this->sendSuccess('delete successfully');
        }
        return $this->sendError('cant delete');
    }

    public function getSelectList(Request $request)
    {
        $input = $request->except(['skip', 'limit']);
        $data = $this->showRepository->all($input, null, null, null, ['id' => 'desc']);

        $data1 = $data[0];
        if (isset($input['room_id']) && !is_null($data)) {
            $search['show_id'] = $data1->id;
            $search['room_id'] = $data1->room_id;
            $search['show_time'] = $data1->show_date . " " . $data1->show_time;
            $data1->show_room = $this->showRoomRepository->all($search, null, null, null, ['id' => 'asc']);
        }
        return $this->sendResponse($data, 'show select-list');
    }

}
