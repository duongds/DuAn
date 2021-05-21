<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\ShowRoom;
use App\Repositories\ShowRepository;
use App\Repositories\ShowRoomRepository;
use App\Utils\CommonUtils;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShowController extends AppBaseController
{
    protected $showRepository;

    public function __construct(ShowRepository $showRepo)
    {
        $this->showRepository = $showRepo;
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
        $data = $this->showRepository->paginate($search, $limit, null, null);
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
        \DB::beginTransaction();
        try {

            $data = $this->showRepository->create($input);

            ShowRoom::updateOrCreate([]);
            \DB::commit();
            return $this->sendResponse($data, 'Store show successfully');

        } catch (\Exception $e) {
            \DB::rollBack();

            return $this->sendError('Cant update products');
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

        $data = $this->showRepository->allQuery($input, null, null, null)->get();

        return $this->sendResponse($data, 'show select-list');
    }
}
