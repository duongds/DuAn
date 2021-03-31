<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
class UserRepository extends BaseRepository{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
    public function getUser()
    {
        return User::latest()->get();
    }
    public function createUser(Request $request){
        return User::create($request);
    }
    public function updateUser($request, $id){
        if ($user=User::find($id)){
            $user->update($request);
            return true;
        }
        return false;
    }
    public function deleteUser($id){
        if ($user=User::find($id)){
            $user->delete();
            return true;
        }
        return false;
    }
}

