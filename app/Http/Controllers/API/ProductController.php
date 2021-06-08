<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateProductAPIRequest;
use App\Http\Requests\API\UpdateProductAPIRequest;
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
        $data = $this->productRepo->paginate($search, $limit, null, ['id' => 'desc']);
        return $this->sendResponse($data, 'Get list booking successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateProductAPIRequest $request
     * @return Response
     */
    public function store(CreateProductAPIRequest $request)
    {
        $input = $request->all();

        $input['category'] = explode(",", $input['category']);

        $category_arr = Category::whereIn('name', $input['category'])->pluck('id')->toArray();
        unset($input['category']);
        $img_arr = ['jpeg','png','jpg','gif','svg'];
        $is_image = false;
        foreach ($img_arr as $img){
            if (strpos($input['poster'], $img)){
                $is_image = true;
                break;
            }
        }
        if (!$is_image){
            return $this->sendError('Định dạng file gửi lên phải là ảnh');
        }

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
     * @param UpdateProductAPIRequest $request
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
        $input = $request->except(['skip', 'limit']);
        $data = $this->productRepo->all($input, null, null, null, ['id' => 'asc']);
        return $this->sendResponse($data, 'get product successfully');
    }

    public function saveImage(Request $request){
        $input = $request->except(['limit', 'skip']);
        if (!isset($input['old_poster'])){
            $input['old_poster'] = '';
        }
        $file = $request->file('poster');
        return  $this->productRepo->uploadImage('product', $file, $input['old_poster']);
    }

    public function  recommendFilm (){
        return $this->productRepo->recommendProduct();
    }
}
