<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFormRequest;
use App\Main\Config\AppConst;
use App\Main\Helpers\Response;
use App\Main\Services\ImageProductService;
use App\Main\Services\ProductService;
use App\Main\Services\ProductTagService;
use Illuminate\Http\Request;

class ProductController extends Controller
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
        $orderBy = $request['order_by']??'id';
        return $this->productService->getAllProducts($data, $orderBy);
    }
    public function show($slug)
    {
        return $this->productService->getBySlug($slug);
    }

    public function getByCategory($slug, Request $request)
    {
        $page = (int)$request->page;
        $data = [
            'page' => !empty($page) ? abs($page) : 1,
            'limit' => !empty($request->limit) ? (int)$request->limit : AppConst::PAGE_LIMIT,
            'name' => $request->name,

        ];
        return $this->productService->getProductBySlugCategory($slug,$data);
    }
}
