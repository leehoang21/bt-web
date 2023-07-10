<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryFormRequest;
use App\Main\Config\AppConst;

use App\Main\Helpers\Response;
use App\Main\Services\CategoryService;
use App\Main\Services\ImageCategoryService;
use Illuminate\Http\Request;

class CategoryAdminController extends Controller
{
    protected $service;
    protected ImageCategoryService $imageProductService;

    public function __construct(
        CategoryService $service,
        ImageCategoryService $imageProductService,
    )
    {
        $this->service = $service;
        $this->imageProductService = $imageProductService;
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

    public function store(CategoryFormRequest $request)
    {

        $data = [
            'data' =>
                [
                    'name' => $request['name'],
                    'slug' => $request['slug'],
                    'color' => $request['color'],

                ],

        ];

        $result= $this->service->save($data);

        if ($result->status() == Response::HTTP_CODE_SUCCESS) {

            $images = $request['images'];

            $id = json_decode($result->content(), true)['data']['id'];

            $re = $this->imageProductService->createData($id, $images);

            if ($re->status() != Response::HTTP_CODE_SUCCESS)
                return $re;
            else
                return $result;
        }
        return (new \App\Main\Helpers\Response)->responseJsonFail(
            [
                'message' => 'Create category fail',

            ],
            Response::RESPONSE_STATUS_FAIL,
        );
    }
    public function show($id)
    {
        return $this->service->getById($id);
    }

    public function update(CategoryFormRequest $request, $id)
    {
        $data = [
            'id' => $id,
            'data' =>
                [
                    'name' => $request['name'],
                    'slug' => $request['slug'],
                    'color' => $request['color'],


                ],
        ];

        $result= $this->service->save($data);

        if ($result->status() == Response::HTTP_CODE_SUCCESS) {
            $images = $request['images'];

            $re = $this->imageProductService->updateData($id, $images);

            if ($re->status() != Response::HTTP_CODE_SUCCESS)
                return $re;

            else
                return $result;
        }

        return (new \App\Main\Helpers\Response)->responseJsonFail(
            [
                'message' => 'Update category fail',

            ],
            Response::RESPONSE_STATUS_FAIL,
        );
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
