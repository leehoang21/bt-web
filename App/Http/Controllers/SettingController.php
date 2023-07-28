<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingFormRequest;
use App\Main\Config\AppConst;
use App\Main\Services\SettingService;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $service;

    public function __construct(
        SettingService $service
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
            'keyword' => $request['keyword'],
            'search_fields' => $request['search_fields']
        ];
        return $this->service->getAll($data);
    }

}
