<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFormRequest;
use App\Main\Services\ProductService;
use AppConst;
use Illuminate\Http\Request;

class ProductAdminController extends Controller
{
    protected $productService;

    public function __construct(
        ProductService $productService
    )
    {
        $this->productService = $productService;
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
            ],

        ];

        return $this->productService->save($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->productService->getProductById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductFormRequest $request, $id)
    {
        $data = [
            'id' => $id,
            'product' => [
                'category_id' => $request->category_id,
                'name' => $request->name,
                'short_description' => $request->short_description,
                'price' => $request->price,
                'slug' => $request->slug,
                'description' => $request->description,
            ],
        ];

        return $this->productService->save($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->productService->delete($id);
    }
}
