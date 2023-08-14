<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFormRequest;
use App\Main\Config\AppConst;
use App\Main\Helpers\Response;
use App\Main\Services\ImageProductService;
use App\Main\Services\ProductCategoryService;
use App\Main\Services\ProductService;
use App\Main\Services\ProductTagService;
use Illuminate\Http\Request;

class ProductAdminController extends Controller
{
    protected $productService;
    protected ImageProductService $imageProductService;
    protected ProductTagService $productTagService;
    protected ProductCategoryService $productCategoryService;

    public function __construct(
        ProductService         $productService,
        ImageProductService    $imageProductService,
        ProductTagService      $productTagService,
        ProductCategoryService $productCategoryService

    )
    {
        $this->productService = $productService;
        $this->imageProductService = $imageProductService;
        $this->productTagService = $productTagService;
        $this->productCategoryService = $productCategoryService;
    }

    public function index(Request $request)
    {
        $page = (int)$request->page;
        $data = [
            'page' => !empty($page) ? abs($page) : 1,
            'limit' => !empty($request->limit) ? (int)$request->limit : AppConst::PAGE_LIMIT,
            'name' => $request->name,
            'keyword' => $request->keyword,
            'search_fields' => $request['search_fields']
        ];
        $orderBy = $request['order_by'] ?? 'products.id';

        return $this->productService->getAllProducts($data, $orderBy);
    }

    public function store(ProductFormRequest $request)
    {
        $data = [
            'product' =>
                [

                    'name' => $request->name,
                    'short_description' => $request->short_description,
                    'price' => $request->price,
                    'slug' => $request->slug,
                    'description' => $request->description,

                    'total' => $request->total,
                    'serial_number' => $request->serial_number,
                    'warranty_period' => $request->warranty_period,

                ],

        ];

        $result = $this->productService->save($data);

        if ($result->status() == Response::HTTP_CODE_SUCCESS) {
            //add images
            $images = $request['images'];

            $id = json_decode($result->content(), true)['data']['id'];

            $re = $this->imageProductService->createData($id, $images);
            //add tags
            $tags = $request['tags'];
            $res = $this->productTagService->createData($id, $tags);
            //add catigories
            $categories = $request['categories'];
            $r = $this->productCategoryService->createData($id, $categories);
            //check status

        }
        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $result = $this->productService->getBySlug($slug);
        return $result;
    }


    public function update(ProductFormRequest $request, $id)
    {
        $data = [
            'id' => $id,
            'product' => [
                'name' => $request->name,
                'short_description' => $request->short_description,
                'price' => $request->price,
                'slug' => $request->slug,
                'description' => $request->description,
                'total' => $request->total,
                'serial_number' => $request->serial_number,
                'warranty_period' => $request->warranty_period,

            ],
        ];

        $result = $this->productService->save($data);

        if ($result->status() == Response::HTTP_CODE_SUCCESS) {
            //add images
            $images = $request['images'];

            $re = $this->imageProductService->updateData($id, $images);
            //tags
            $tags = $request['tags'];
            $res = $this->productTagService->updateData($id, $tags);
            //add catigories
            $categories = $request['categories'];
            $r = $this->productCategoryService->updateData($id, $categories);

        }
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->productService->delete($id);
    }
}
