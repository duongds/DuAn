<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductCategoryXrefRepository;
use App\Repositories\ProductRepository;
use App\Utils\CommonUtils;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends AppBaseController
{
    protected $productRepo;
    protected $productCategoryXrefRepository;
    protected $categoryRepository;

    public function __construct(ProductRepository $productRepository, ProductCategoryXrefRepository $productCategoryXrefRepo, CategoryRepository $categoryRepo)
    {
        $this->productRepo = $productRepository;
        $this->productCategoryXrefRepository = $productCategoryXrefRepo;
        $this->categoryRepository = $categoryRepo;
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
        $data = $this->productRepo->paginate($search, $limit, null, null);
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

        $file = $request->file('poster');

        $originalFile = $file->getClientOriginalName();

        $input['poster'] = $this->productRepo->uploadImage('product', $originalFile);

        $input['category'] = explode(",", $input['category']);

        $category_arr = Category::whereIn('name', $input['category'])->pluck('id')->toArray();
        unset($input['category']);

        \DB::beginTransaction();
        try {
            $data = $this->productRepo->create($input);

            $this->productRepo->setModel()->find($data->id)->category()->sync($category_arr);

            \DB::commit();

            return $this->sendResponse($data, 'Store product successfully');

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
        $data = $this->productRepo->find($id);
        return $this->sendResponse($data, 'Show product successfully');
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

        $product = $this->productRepo->find($id);

        if (empty($product)) {
            return $this->sendError('Product not found');
        }
        $input['poster'] = $this->productRepo->uploadImage('product', $input['poster']);

        $input['category'] = explode(",", $input['category']);

        $category_arr = Category::whereIn('name', $input['category'])->pluck('id')->toArray();
        unset($input['category']);

        \DB::beginTransaction();
        try {
            $data = $this->productRepo->update($input, $id);

            $this->productRepo->setModel()->find($id)->category()->detach();
            $this->productRepo->setModel()->find($id)->category()->sync($category_arr);

            \DB::commit();

            return $this->sendResponse($data, 'Update product success');

        } catch (\Exception $e) {
            \DB::rollBack();

            return $this->sendError('Cant update products');
        }

    }


    public function destroy($id)
    {
        if ($this->productRepo->delete($id)) {
            return $this->sendSuccess('Delete successfully');
        }
        return $this->sendError('cant delete');
    }

    public function getSelectList(Request $request)
    {
        $name = $request->get('name');
        $data = $this->productRepo->findByName($name);
        return $this->sendResponse($data, 'get product successfully');
    }
}
