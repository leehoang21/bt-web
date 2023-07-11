<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostFormRequest;
use App\Main\Config\AppConst;
use App\Main\Helpers\Response;
use App\Main\Services\ImagePostService;
use App\Main\Services\PostService;
use App\Main\Services\TagPostService;
use Illuminate\Http\Request;

class PostAdminController extends Controller
{
    protected $service;
    protected ImagePostService $imagePostService;
    protected TagPostService $postService;

    public function __construct(
        PostService      $service,
        ImagePostService $imagePostService,
        TagPostService   $postService
    )
    {
        $this->service = $service;
        $this->imagePostService = $imagePostService;
        $this->postService = $postService;

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

    public function store(PostFormRequest $request)
    {

        $data = [
            'post' =>
                [
                    'title' => $request->title,
                    'slug' => $request->slug,
                    'content' => $request['content'],
                ],

        ];
        $result = $this->service->save($data);
        if ($result->status() == Response::HTTP_CODE_SUCCESS) {
            $images = $request['images'];
            $id = json_decode($result->content(), true)['data']['id'];
            $re = $this->imagePostService->createData($id, $images);
            //
            $tags = $request['tags'];
            $res = $this->postService->createData($id, $tags);
            if ($re->status() != Response::HTTP_CODE_SUCCESS)
                return $re;
            else if ($res->status() != Response::HTTP_CODE_SUCCESS)
                return $res;
            else
                return $result;
        }
        return (new \App\Main\Helpers\Response)->responseJsonFail(
            [
                'message' => 'Create post fail',

            ],
            Response::RESPONSE_STATUS_FAIL,
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        return $this->service->getBySlug($slug);
    }


    public function update(PostFormRequest $request, $id)
    {
        $data = [
            'id' => $id,
            'post' =>
                [
                    'title' => $request->title,
                    'slug' => $request->slug,
                    'content' => $request['content'],
                ],
        ];
        $result = $this->service->save($data);
        if ($result->status() == Response::HTTP_CODE_SUCCESS) {
            $images = $request['images'];
            $re = $this->imagePostService->updateData($id, $images);
            //
            $tags = $request['tags'];
            $res = $this->postService->updateData($id, $tags);
            if ($re->status() != Response::HTTP_CODE_SUCCESS)
                return $re;
            else if ($res->status() != Response::HTTP_CODE_SUCCESS)
                return $res;
            else
                return (new \App\Main\Helpers\Response)->responseJsonSuccess(null, message: true,
                );
        }
        return $result;
    }

    public function destroy($id)
    {
        $result = $this->service->delete($id);
        if ($result->status() == Response::HTTP_CODE_SUCCESS) {
            return (new \App\Main\Helpers\Response)->responseJsonSuccess(null, message: true,
            );
        }
        return $result;

    }


}
