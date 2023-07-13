<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingFormRequest;
use App\Main\Config\AppConst;
use App\Main\Helpers\Response;
use App\Main\Services\SettingService;

use Illuminate\Http\Request;

class SettingAdminController extends Controller
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
            'keyword' => $request->keyword,
            'search_fields' => $request['search_fields']
        ];
        return $this->service->getAll($data);
    }

    public function store(SettingFormRequest $request)
    {

        $data = [
            'data' =>
                [
                    'content' => $request['content'],
                    'type'=> $request['type'],
                ],

        ];
        return $this->service->save($data);
    }
    public function show($id)
    {
        return $this->service->getById($id);
    }

    public function update(SettingFormRequest $request, $id)
    {
        $data = [
            'id' => $id,
            'data' =>
                [
                    'content' => $request['content'],
                    'type'=> $request['type'],
                ],
        ];

        $result = $this->service->save($data);
        return (new \App\Main\Helpers\Response)->responseJsonSuccess("",message: true,);
    }

    public function destroy($id)
    {
        $result = $this->service->delete($id);
        if($result->status() == Response::HTTP_CODE_SUCCESS)
            return (new \App\Main\Helpers\Response)->responseJsonSuccess("",message: true,);
    }
}
