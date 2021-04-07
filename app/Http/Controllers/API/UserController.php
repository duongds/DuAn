<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends AppBaseController
{
    protected $userRepo;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepo = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = $this->userRepo->getAll();
        return $this->sendResponse($data,'get user successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if ($data = $this->userRepo->create($request->all())) {
            return $this->sendResponse($data,'store user successfully');
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
        $data = $this->userRepo->find($id);
        return $this->sendResponse($data,'show user successfully');
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
        if ($data = $this->userRepo->update($request->all(), $id)) {
            return $this->sendResponse($data,'update user successfully');
        }
        return $this->sendError('cant update user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->userRepo->delete($id)) {
            return $this->sendSuccess('delete successfully');
        }
        return $this->sendError('cant delete user');
    }
}
