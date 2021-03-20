<?php

namespace App\Http\Controllers;

use App\Models\Repo1;
use Illuminate\Http\Request;

class Repo1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $repo1s=Repo1::query()->paginate(10);
        return view('repo1.index',['repo1s'=>$repo1s]);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Repo1::query()->create($request->only('name','job_id','address'));
        return redirect()->route('repo1.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $repo1=Repo1::query()->findOrFail($id);
        return view('repo1.index',['repo1'=>$repo1]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $repo1=Repo1::query()->findOrFail($id);
        return view('repo1.edit',['repo1'=>$repo1]);
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
        $repo1= Repo1::query()->findOrFail($id);
        $repo1->update($request->only('name','job_id','address'));
        return redirect()->route('repo1.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Repo1::destroy($id);
        return redirect()->route('repo1.index');
    }
}
