<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostFormRequest;
use App\Main\Config\AppConst;
use App\Main\Helpers\Response;
use App\Main\Services\ImagePostService;
use App\Main\Services\PostService;
use App\Main\Services\TagPostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $service;
    public function __construct(
        PostService      $service,

    )
    {
        $this->service = $service;

    }

    public function index(Request $request)
    {
        $page = (int)$request->page;
        $data = array(
            'page' => !empty($page) ? abs($page) : 1,
            'limit' => !empty($request->limit) ? (int)$request->limit : AppConst::PAGE_LIMIT,
            'keyword' => $request->keyword,
            'search_fields' => $request['search_fields']
        );
        return $this->service->getAll($data);
    }

    public function show($slug)
    {
        return $this->service->getBySlug($slug);
    }




}
