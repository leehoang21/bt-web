<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
            'page' => !empty($page) ? abs($page) : 1,
            'limit' => !empty($request->limit) ? (int)$request->limit : AppConst::PAGE_LIMIT,
            'key_word' => $request->key_word,
        ];
        return $this->service->getAll($data);
    }

    public function store(TagFormRequest $request)
    {

        $data = [
            'data' =>
                [
                    'name' => $request->name,
                    'slug' => $request->slug,
                    'content'=>$request['content'],
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

    public function update(TagFormRequest $request, $id)
    {
        $data = [
            'id' => $id,
            'data' =>
                [
                    'name' => $request->name,
                    'slug' => $request->slug,
                    'content'=>$request['content'],
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
