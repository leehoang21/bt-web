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
            'key_word' => $request->key_word,
        );
        return $this->service->getAll($data);
    }

    public function showBySlug($slug)
    {
        return $this->service->getBySlug($slug);
    }




}
