<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class UserController extends Controller
{
    protected $userRepo;
    public function __construct(UserRepository  $userRepository){
        $this->userRepo=$userRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=$this->userRepo->getAll();
        return response()->json($data,Response::HTTP_OK);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($data = $this-> userRepo->create($request->all())){
            return response()->json($data, Response::HTTP_OK);
        }
        return response('false', Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.*
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=$this->userRepo->find($id);
        return response()->json($data,Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
        if ($data = $this->userRepo->update($request->all(),$id)) {
            return response('success', Response::HTTP_OK);
        }
        return response('false', Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->userRepo->delete($id)) {
            return response('success', Response::HTTP_OK);
        }
        return response('false', Response::HTTP_BAD_REQUEST);
    }
}
