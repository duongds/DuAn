<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Repositories\CategoryRepository;
use App\Repositories\UserCategoryXrefRepository;
use App\Repositories\UserRepository;
use App\Utils\CommonUtils;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends AppBaseController
{
    protected $userRepo;
    protected $userCategoryXrefRepository;
    protected $categoryRepository;

    public function __construct(UserRepository $userRepository, UserCategoryXrefRepository $userCategoryXrefRepo, CategoryRepository $categoryRepo)
    {
        $this->userRepo = $userRepository;
        $this->userCategoryXrefRepository = $userCategoryXrefRepo;
        $this->categoryRepository = $categoryRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $search = $request->except(['skip', 'limit']);
        $limit = $request->get('limit', CommonUtils::DEFAULT_LIMIT);
        $data = $this->userRepo->paginate($search, $limit, null, null);
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
        $data = $this->userRepo->create($input);
        return $this->sendResponse($data, 'Store user successfully');
    }

    /**
     * Display the specified resource.*
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->userRepo->find($id);
        return $this->sendResponse($data, 'show user successfully');
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
        $user = $this->userRepo->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $data = $this->userRepo->update($input, $id);

        return $this->sendResponse($data, 'Update user success');

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

    public function userCategory(Request $request)
    {
        $input = $request->all();
        $user = \Auth::user();
        $category_arr = $input['category'];
        foreach ($category_arr as $category) {
            $category['user_id'] = $user->id;
            $category['category_id'] = $category['id'];
            unset($category['id']);
            $this->userCategoryXrefRepository->create($category);
        }
        $user->first_time_user = 1;
        $this->userRepo->update($user->toArray(), $user->id);
        return $this->sendSuccess('save category_user successful');
    }
}
