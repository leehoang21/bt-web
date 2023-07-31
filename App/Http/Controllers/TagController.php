<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagFormRequest;
use App\Main\Config\AppConst;
use App\Main\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TagController extends Controller
{
    protected $service;

    public function __construct(
        TagService $service
    )
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $page = (int)$request->page;
        $data = [
            'page' => '',
            'limit' => '',
            'keyword' => '',
            'search_fields' => ''
        ];
        return $this->service->getAll($data);
    }


}
