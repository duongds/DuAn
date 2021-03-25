<?php

namespace App\Http\Controllers;

use App\Models\Repo1;
use App\Repositories\Repo1Repositores;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Repo1Controller extends Controller
{

    protected $repo1Repo;

    public function __construct(Repo1Repositores $repo1Repositores)
    {
        $this->repo1Repo = $repo1Repositores;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
//        $repo1s=Repo1::query()->paginate(10);
//        return view('repo1.index',['repo1s'=>$repo1s]);
        $data = $this->repo1Repo->getRepo();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('repo1.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|Response
     */
    public function store(Request $request)
    {

//        Repo1::query()->create($request->only('name', 'job_id', 'address'));
//        return redirect()->route('repo1.index');
        if ($data = $this->repo1Repo->createRepo($request)) {
            return response()->json($data, Response::HTTP_OK);
        }
        return response('false', Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $repo1 = Repo1::query()->findOrFail($id);
        return view('repo1.index', ['repo1' => $repo1]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $repo1 = Repo1::query()->findOrFail($id);
        return view('repo1.edit', ['repo1' => $repo1]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|void
     */
    public function update(Request $request, $id)
    {
//        $repo1 = Repo1::query()->findOrFail($id);
//        $repo1->update($request->only('name', 'job_id', 'address'));
//        return redirect()->route('repo1.index');
        if ($data = $this->repo1Repo->updateRepo($request, $id)) {
            return response('success', Response::HTTP_OK);
        }
        return response('false', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|void
     */
    public function destroy($id)
    {
        if ($this->repo1Repo->delete($id)) {
            return response('success', Response::HTTP_OK);
        }
        return response('false', Response::HTTP_BAD_REQUEST);
    }
}
