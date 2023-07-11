<?php

namespace App\Http\Controllers;

use App\Main\Config\AppConst;

use App\Main\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    protected $service;

    public function __construct(
        CategoryService $service
    )
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $page = (int)$request->page;
        $data = [
            'page' => !empty($page) ? abs($page) : 1,
            'limit' => !empty($request->limit) ? (int)$request->limit : AppConst::PAGE_LIMIT,
            'keyword' => $request->keyword,
            'search_fields' => $request['search_fields']
        ];
        return $this->service->getAll($data);
    }
}
