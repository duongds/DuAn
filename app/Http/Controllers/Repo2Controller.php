<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Repo2;

class Repo2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $repo2s= Repo2::query()->paginate(10);
        return view('repo2.index',['repo2s'=>$repo2s]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('repo2.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Repo2::query()->create()->only('job_name','address');
        return redirect()->route('repo2.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $repo2=Repo2::query()->findOrFail($id);
        return view('repo2.index',['repo2'=>$repo2]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $repo2=Repo2::query()->findOrFail($id);
        return view('repo2.edit',['repo2'=>$repo2]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $repo2=Repo2::query()->findOrFail($id);
        Repo2::query()->update($request->only('job_name','address'));
        return redirect()->route('repo2.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Repo2::destroy($id);
        return redirect()->route('repo2.index');
    }
}
