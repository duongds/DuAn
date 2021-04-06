<?php


namespace App\Repositories;


use App\Models\Repo1;
use Illuminate\Http\Request;

class Repo1Repositores extends BaseRepository
{
    public function __construct(Repo1 $model)
    {
        parent::__construct($model);
    }

    function getRepo()
    {
        return Repo1::latest()->get();
    }

    function createRepo(Request $request)
    {
        $repo = $request->all(['name', 'job_id', 'address']);
        return Repo1::create($repo);
    }

    function updateRepo(Request $request, $id)
    {
        if (Repo1::find($id)) {
            $repo = $request->all(['name', 'job_id', 'address']);
            return Repo1::where('id', $id)->update($repo);
        }
        return false;
    }

    function deleteRepo($id)
    {
        if (Repo1::find($id)) {
            Repo1::where('id', $id)->delete();
            return true;
        }
        return false;
    }
}
