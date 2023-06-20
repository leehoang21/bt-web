<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFormRequest;
use App\Main\Config\AppConst;
use App\Main\Helpers\Response;
use App\Main\Services\ImageProductService;
use App\Main\Services\ProductService;
use App\Main\Services\ProductTagService;
use Illuminate\Http\Request;

class ProductAdminController extends Controller
{
    protected $productService;
    protected ImageProductService $imageProductService;
    protected  ProductTagService $productTagService;

    public function __construct(
        ProductService      $productService,
        ImageProductService $imageProductService,
        ProductTagService   $productTagService

    )
    {
        $this->productService = $productService;
        $this->imageProductService = $imageProductService;
        $this->productTagService = $productTagService;
    }

    public function index(Request $request)
    {
        $page = (int)$request->page;
        $data = [
            'page' => !empty($page) ? abs($page) : 1,
            'limit' => !empty($request->limit) ? (int)$request->limit : AppConst::PAGE_LIMIT,
            'name' => $request->name,

        ];
        return $this->productService->getAllProducts($data);
    }

    public function store(ProductFormRequest $request)
    {

        $data = [
            'product' =>
                [
                    'category_id' => $request->category_id,
                    'name' => $request->name,
                    'short_description' => $request->short_description,
                    'price' => $request->price,
                    'slug' => $request->slug,
                    'description' => $request->description,
                    'id_category' => $request->id_category,
                ],

        ];
        $result = $this->productService->save($data);
        if ($result->status() == Response::HTTP_CODE_SUCCESS) {
            $images = $request['images'];
            $id = json_decode($result->content(), true)['data']['id'];
            $re = $this->imageProductService->createData($id, $images);
            //
            $tags = $request['tags'];
            $res = $this->productTagService->createData($id, $tags);
            if ($re->status() != Response::HTTP_CODE_SUCCESS)
                return $re;
            else if($res->status() != Response::HTTP_CODE_SUCCESS)
                return $res;
            else
                return $result;
        }
        return (new \App\Main\Helpers\Response)->responseJsonFail(
            [
                'message' => 'Create product fail',

            ],
            Response::RESPONSE_STATUS_FAIL,
        );

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->productService->getProductById($id);
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
                'id_category' => $request->id_category,
            ],
        ];
        $result = $this->productService->save($data);
        if ($result->status() == Response::HTTP_CODE_SUCCESS) {
            $images = $request['images'];
            $re = $this->imageProductService->updateData($id, $images);
            //
            $tags = $request['tags'];
            $res = $this->productTagService->updateData($id, $tags);
            if ($re->status() != Response::HTTP_CODE_SUCCESS)
                return $re;
            else if($res->status() != Response::HTTP_CODE_SUCCESS)
                return $res;
            else
                return $result;
        }

        return (new \App\Main\Helpers\Response)->responseJsonFail(
            [
                'message' => 'Update product fail',

            ],
            Response::RESPONSE_STATUS_FAIL,
        );
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
