<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingFormRequest;
use App\Main\Config\AppConst;
use App\Main\Services\SettingService;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
            'key_word' => $request->key_word,
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

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
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

        return $this->service->save($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
